<?php

namespace App\Form;

use App\Entity\Application;
use App\Entity\MotivationLetter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class MotivationLetterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'Contenu de la lettre',
                'attr' => ['placeholder' => 'Exprimez votre motivation ici...', 'class' => 'form-control mb-4',],
                'required' => false,
            ])
            ->add('application', EntityType::class, [
                'label' => 'Candidature',
                // looks for choices from this entity
                'class' => Application::class,
                // uses the User.username property as the visible option string
                'choice_label' => function ($application) {
                    return $application->getJobTitle() . ' chez ' . $application->getCompanyName();
                },
                'attr' => [
                    'class' => 'form-control mb-4',
                ]
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            ->add('chatgptLink', TextareaType::class, [
                'label' => 'Lien chatgpt',
                'attr' => ['class' => 'form-control mb-4',],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MotivationLetter::class,
        ]);
    }
}
