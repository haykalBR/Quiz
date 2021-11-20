<?php

namespace App\Domain\Exam\Form;

use App\Domain\Exam\Entity\Exam;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
                                                              ->add('title')
                                                   ->add('duration')
                                                   ->add('passingPercentage')
                                                   ->add('nbQuestions')
                               ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Exam::class,
        ]);
    }
}
