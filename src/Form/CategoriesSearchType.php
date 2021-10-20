<?php

namespace App\Form;

use App\Domain\Categories\Entity\Categories;
use App\Domain\Categories\Repository\CategoriesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoriesSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder
                ->add('search_public', ChoiceType::class, [
                'choices' => [
                    'published' => true,
                    'not published ' => false,
                    'All' => "",
                ],])
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

        ]);
    }
}
