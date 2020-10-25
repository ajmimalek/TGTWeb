<?php

namespace FormationsBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class courType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titreCour')->add('descriptionCour')
            ->add('dureeCour')
            ->add('textCour')
            ->add('image',FileType::class,array('label'=>'Déposez un video ou image','data_class'=>null))
        ->add('formations',EntityType::class,array(
        'class'=>'FormationsBundle:formation',
        'multiple'=>false));
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FormationsBundle\Entity\cour'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'formationsbundle_cour';
    }


}
