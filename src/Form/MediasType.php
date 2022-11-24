<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Medias;
use App\Entity\MediasSections;
use App\Entity\Users;
use http\Client\Curl\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediasType extends AbstractType
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
                'multiple' => false
            ])
            ->add('user',EntityType::class, [
                'label' => 'Utilisateurs',
                'class' => Users::class,
            ])
            ->add('categories', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Categories::class,
                'expanded' => true,
                'multiple' => true,
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
