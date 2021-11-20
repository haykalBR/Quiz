<?php

namespace App\Domain\User\Form;

use App\Domain\User\Entity\Permissions;
use App\Domain\User\Service\PermessionService;
use App\Domain\User\Subscriber\PermissionsFormSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PermissionsType extends AbstractType
{
    /**
     * @var PermessionService
     */
    private PermessionService $permessionService;
    /**
     * @var PermissionsFormSubscriber
     */
    private PermissionsFormSubscriber $permissionsFormSubscriber;

    public function __construct(PermessionService $permessionService,PermissionsFormSubscriber $permissionsFormSubscriber)
    {
        $this->permessionService = $permessionService;
        $this->permissionsFormSubscriber = $permissionsFormSubscriber;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('guardName', ChoiceType::class, [
                'choices'      => $this->permessionService->findNewGuardName(),
                'choice_label' => function ($choice) {
                    return $choice;
                },
                'multiple' => false,

            ]);
        $builder->addEventSubscriber($this->permissionsFormSubscriber);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Permissions::class,
        ]);
    }
}
