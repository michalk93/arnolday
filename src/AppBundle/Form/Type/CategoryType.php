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
                   'choices' => array('Red' => 'Red', 'Green' => 'Green', 'Blue' => 'Blue')
               ))
               ->add('save', 'submit');
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
 