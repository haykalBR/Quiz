<?php

namespace App\Form;

use App\Core\FormType\DropifyType;
use App\Core\FormType\SwitchType;
use App\Domain\Categories\Entity\Categories;
use App\Domain\Categories\Repository\CategoriesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('public', SwitchType::class)
            ->add('file', DropifyType::class)
            ->add('parent', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'name',
                'multiple'=>false,
                'by_reference' => false,
                'required' => false,
                'query_builder' => function (CategoriesRepository $repository) {
                    return $repository->getCategoriesParent();
                },
                'attr' => [
                    'class' => 'select2'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class' => Categories::class
        ]);
    }
}
