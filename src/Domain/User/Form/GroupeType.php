<?php

namespace App\Domain\User\Form;

use App\Domain\User\Entity\Groupe;
use App\Domain\User\Entity\Roles;
use App\Domain\User\Repository\RolesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('roles', EntityType::class, [
                'class' => Roles::class,
                'choice_label' => 'name',
                'multiple'=>true,
                'by_reference' => false,
                'required' => true,
                'query_builder' => function (RolesRepository $repository) {
                    return $repository->getRolesWithoutAdmin();
                },
            ])
          ->add('name')
          ->add('description');
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Groupe::class,
        ]);
    }
}
