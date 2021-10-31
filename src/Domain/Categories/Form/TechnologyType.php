<?php

namespace App\Domain\Categories\Form;

use App\Domain\Categories\Entity\Technology;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechnologyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
                                                              ->add('name')
                                                   ->add('slug')
                                                   ->add('uploadDir')
                                                   ->add('namer')
                                                   ->add('allowedTypes')
                                                   ->add('file')
                                                   ->add('path')
                                                   ->add('rootDir')
                                                   ->add('webSubDir')
                                                   ->add('webDir')
                                                   ->add('relativePath')
                                                   ->add('relativeUrl')
                                                   ->add('absolutePath')
                                                   ->add('absoluteUploadDir')
                                                   ->add('filters')
                                                   ->add('createdAt')
                                                   ->add('updatedAt')
                                                   ->add('deletedAt')
                               ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Technology::class,
        ]);
    }
}
