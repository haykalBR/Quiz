<?php
namespace App\Core\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SwitchType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => ['class' => 'chkSwitch','data-toggle'=>'switchbutton'],
            'label' => false
        ]);
    }

    public function getParent(): string
    {
        return CheckboxType::class;
    }
}