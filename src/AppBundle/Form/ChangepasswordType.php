<?php
namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class ChangepasswordType extends AbstractType
{
        /**
         * {@inheritdoc}
         */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('username')->add('Email')
        ->add('newpassword', null, [
              'attr'=>[
                        'placeholder'=> 'Nouveau mot de passe',
                      ]]);
      }
      /**
       * {@inheritdoc}
       */
  public function configureOptions(OptionsResolver $resolver)
  {
      $resolver->setDefaults(array(
          'attr' =>['novalidate' => 'novalidate']
      ));
  }
}
