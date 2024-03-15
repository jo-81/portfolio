<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'attr' => ['required' => false],
                'label' => 'Image',
                'allow_delete' => false,
            ])
            ->add('alt', TextType::class, [
                'label' => 'Text alternatif',
                'help' => 'Description de l\'image',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
            'upload_dir' => '/images/posts/',
            'upload_filename' => '/images/posts/',
        ]);
    }
}
