<?php

namespace App\Domain\User\Form;

use App\Domain\Roles\Repository\Domain\User\Entity\RolesRepository;
use App\Domain\User\Entity\Roles;
use App\Domain\User\Entity\User;
use App\Domain\User\Subscriber\UserFormSubscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @var UserFormSubscriber
     */
    private UserFormSubscriber $userFormSubscriber;

    /**
     * @param UserFormSubscriber $userFormSubscriber
     */
    public function __construct(UserFormSubscriber $userFormSubscriber)
    {
        $this->userFormSubscriber = $userFormSubscriber;

    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('email')
           ->add('firstName')
           ->add('lastName')
           ->add('birthDate')
           ->add('enabled')
            ->add('role', EntityType::class, [
                'class' => Roles::class,
                'choice_label' => 'name',
                'multiple'=>true,
                'by_reference' => false,
                'required' => true,
                'query_builder' => function (RolesRepository $repository) {
                    return $repository->getRolesWithoutAdmin();
                },
            ])
            ->add('grantPermission', ChoiceType::class,[
                'required' => false,
                'multiple'=>true,
            ])
            ->add('revokePermission', ChoiceType::class,[
                'required' => false,
                'multiple'=>true,
            ]);
        ;
        $builder->addEventSubscriber($this->userFormSubscriber);

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
