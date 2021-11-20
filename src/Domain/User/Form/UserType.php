<?php

namespace App\Domain\User\Form;

use App\Domain\User\Entity\User;
use App\Domain\User\Subscriber\UserFormSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
