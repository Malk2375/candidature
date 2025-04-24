<?php

namespace App\Form;

use App\Entity\Application;
use SebastianBergmann\CodeCoverage\Report\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jobTitle', TextareaType::class, [
                'label' => 'Intitulé du poste',
//                'required' => false,
            ])
            ->add('companyName', TextareaType::class, [
                'label' => 'L\'entreprise',
//                'required' => false,
            ])
            ->add('jobLink', TextareaType::class, [
                'label' => 'Lien de l\'offre',
                'required' => false,
            ])
            ->add('jobDescription', TextareaType::class, [
                'label' => 'Description du poste',
//                'required' => false,
            ])
            ->add('applicationDate', null, [
                'widget' => 'single_text',
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
