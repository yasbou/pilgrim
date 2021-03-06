<?php

namespace AppBundle\Form\Info;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class InfoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')->add('soustitre')->add('listeA', null, array(
    'required'   => false,))
->add('listeB', null, array(
'required'   => false,))
->add('listeC', null, array(
'required'   => false,))
->add('listeD', null, array(
'required'   => false,))
->add('listeE', null, array(
'required'   => false,))
->add('image', FileType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Info\Info'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_info_info';
    }


}
