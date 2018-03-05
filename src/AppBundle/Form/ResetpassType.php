<?php  
namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class ResetpassType extends AbstractType
{
        /**
         * {@inheritdoc}
         */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('Email');
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
