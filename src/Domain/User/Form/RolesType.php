<?php

namespace App\Domain\User\Form;

use App\Domain\User\Entity\Permissions;
use App\Domain\User\Entity\Roles;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RolesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
          ->add('guardName')
          ->add('name')
            ->add('permissions', EntityType::class, [
                'class' => Permissions::class,
                'choice_label' => 'name',
                'multiple' => true,
                'by_reference' => false,
                'required' => false,
                'attr' => [
                    'class' => 'select2',
                ],
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Roles::class,
        ]);
    }
}
