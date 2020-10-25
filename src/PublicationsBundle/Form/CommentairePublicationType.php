<?php

namespace PublicationsBundle\Form;

use blackknight467\StarRatingBundle\Form\RatingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentairePublicationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder   ->add('ratingComm', RatingType::class , ['label_attr' => [
            'style' => 'display: none;',
        ]
        ])
            ->add('contenu', TextType::class,[
            'attr' => [
                'placeholder' => 'Ajouter votre commentaire',
                'style' => 'width : 60%',
            ],
            'label_attr' => [
                'style' => 'display: none;',
            ]
        ])
            ->add('Valider', SubmitType::class, [
                'attr' => [
                    'class' => 'btn musica-btn m-2'
                ]
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PublicationsBundle\Entity\CommentairePublication'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'publicationsbundle_commentairepublication';
    }


}
