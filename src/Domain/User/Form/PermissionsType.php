<?php

namespace App\Domain\User\Form;

use App\Domain\User\Entity\Permissions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PermissionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
                                                              ->add('guardName')
                                                   ->add('name')
                                                   ->add('roles')
                                                   ->add('users')
                               ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Permissions::class,
        ]);
    }
}
