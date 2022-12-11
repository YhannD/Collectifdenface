<?php

namespace App\Form;

use App\Entity\Exhibitions;
use App\Entity\ExhibitionsYears;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExhibitionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'exposition'
            ])
            ->add('description', TextType::class, [
                'label' => 'Description de l\'exposition'
            ])
            ->add('exhibitionsImages', FileType::class,[
                'multiple'=> true,
                'mapped' => false,
                'required' => true,
                'label' => 'Images'
            ])
            ->add('exhibitionsYears', EntityType::class, [
                'label' => false,
                'required' => true,
                'class' => ExhibitionsYears::class,
                'expanded' => false,
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exhibitions::class,
        ]);
    }
}
