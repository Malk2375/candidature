<?php

namespace App\Form;

use App\Entity\Application;
use SebastianBergmann\CodeCoverage\Report\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jobTitle', TextType::class, [
                'label' => 'Intitulé du poste',
//                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-4',
                ]
            ])
            ->add('companyName', TextType::class, [
                'label' => 'L\'entreprise',
//                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-4',
                ]
            ])
            ->add('jobLink', TextType::class, [
                'label' => 'Lien de l\'offre',
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-4',
                ]
            ])
            ->add('jobDescription', TextareaType::class, [
                'label' => 'Description du poste',
//                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-4',
                ]
            ])
            ->add('applicationDate', null, [
                'label' => 'Date de la candidature',
                'widget' => 'single_text',
                'required' => false, // Champ non requis
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
