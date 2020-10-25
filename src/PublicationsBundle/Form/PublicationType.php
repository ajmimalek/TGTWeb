<?php

namespace PublicationsBundle\Form;

use PublicationsBundle\Entity\CategoriePublication;
use PublicationsBundle\Entity\Publication;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PublicationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('contenue', TextareaType::class,
            ['attr' => [
                'placeholder' => 'Exprimez-vous',
                'cols' => '30',
                'rows' => '10',
                'label' => false],
            ])
            ->add('localisation', ChoiceType::class, [
                'choices' => [
                    'Ariana' => 'Ariana',
                    'Ben Arous' => 'Ben Arous',
                    'Tunis' => 'Tunis',
                    'Manouba' => 'Manouba',
                    'Sfax' => 'Sfax',
                    'Béja' => 'Béja',
                    'Bizerte' => 'Bizerte',
                    'Gabes' => 'Gabes',
                    'Gafsa' => 'Gafsa',
                    'Jendouba' => 'Jendouba',
                    'Kairaouan' => 'Kairaouan',
                    'Kasserine' => 'Kasserine',
                    'Kébili' => 'Kébili',
                    'Le Kef' => 'Le Kef',
                    'Mahdia' => 'Mahdia',
                    'Médenine' => 'Médenine',
                    'Monastir' => 'Monastir',
                    'Nabeul' => 'Nabeul',
                    'Sidi Bouzid' => 'Sidi Bouzid',
                    'Siliana' => 'Siliana',
                    'Sousse' => 'Sousse',
                    'Tataouine' => 'Tataouine',
                    'Tozeur' => 'Tozeur',
                    'Zaghouan' => 'Zaghouan'
                ],
            ])
            ->add('categorie', EntityType::class, [
                'class' => CategoriePublication::class,
                'choice_label' => 'nomCat',
                'label_attr' => [
                    'style' => 'display: none;',
                ]
            ])
            ->add('video', FileType::class, [
                'label_attr' => [
                    'style' => 'display: none;',
                ],
                'data_class' => null,
                'required' => false,
                'attr' => [
                    'class' => 'file',
                    'accept' => 'video/*'
                ],
            ])
            ->add('Publier', SubmitType::class, ['attr' => [
                'class' => 'btn musica-btn m-2',
            ]]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Publication::class,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'publicationsbundle_publication';
    }


}
