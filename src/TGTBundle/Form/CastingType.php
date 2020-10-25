<?php

namespace TGTBundle\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CastingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('Organisation_id')
            ->add('titreCasting')
            ->add('descriptionCasting',CKEditorType::class)
            ->add('dateCasting',DateTimeType::class , [ 'widget' => 'single_text' ])
            ->add('dateLP',DateTimeType::class , [ 'widget' => 'single_text' ])
            ->add('ThemeCasting',ChoiceType::class,['choices'=>[''=>'','Mode & Pub' =>'Mode & Pub','Theatre & Humour'=>'Theatre & Humour','Cinéma & Fiction'=>'Cinéma & Fiction','Musique & Dance'=>'Musique & Dance','Télévision & Radio'=>'Télévision & Radio','Peinture & Art plastique'=>'Peinture & Art plastique','Sports & Arts de cirque'=>'Sports & Arts de cirque','Audiovisuel'=>'Audiovisuel'] ])
            ->add('adresseCasting')
            ->add('imageCasting',FileType::class,array('label'=>'Veuillez selectionner votre photo','data_class'=>null))
            ->add('Valider',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TGTBundle\Entity\Casting'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tgtbundle_casting';
    }


}
