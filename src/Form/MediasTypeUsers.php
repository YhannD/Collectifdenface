<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Medias;
use App\Entity\MediasMusics;
use App\Entity\MediasSections;
use App\Entity\MediasVideos;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediasTypeUsers extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du media'
            ])
            ->add('description', TextType::class, [
                'label' => 'Description du media'
            ])
            ->add('mediasSections', EntityType::class, [
                'label' => false,
                'required' => true,
                'class' => MediasSections::class,
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('categories', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Categories::class,
                'expanded' => true,
                'multiple' => true
            ])
            ->add('mediasImages', FileType::class,[
                'multiple'=> true,
                'mapped' => false,
                'required' => false,
                'label' => 'Image(s)',

            ])
            ->add('mediasMusics',TextType::class,[
                'required' => false,
                'mapped' => false,
                'label' => 'Musique',
                'attr' => [
                    'placeholder' => 'Copier l\'URL ici',
                ]
                ])
            ->add('mediasVideos',TextType::class,[
                'required' => false,
                'mapped' => false,
                'label' => 'Vidéo',
                'attr' => [
                    'placeholder' => 'Copier l\'URL ici',
                ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Medias::class,
        ]);
    }
}
