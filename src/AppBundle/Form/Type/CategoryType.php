<?php

 namespace AppBundle\Form\Type;

 use Symfony\Component\Form\AbstractType;
 use Symfony\Component\Form\FormBuilderInterface;
 use Symfony\Component\OptionsResolver\OptionsResolverInterface;

 class CategoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
       $builder
               ->add('name', 'text')
               ->add('color', 'choice', array(
                   'choices' => array('#FF1A1A' => 'Red', '#26A826' => 'Green', '#1A1AFF' => 'Blue')
               ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
       $resolver->setDefaults(array(
           'data_class' => 'AppBundle\Entity\Category',
       ));
    }

    public function getName() {
       return 'category_form';
    }

 }
 