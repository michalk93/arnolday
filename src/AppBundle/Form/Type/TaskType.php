<?php
namespace AppBundle\Form\Type;
/**
 * Created by PhpStorm.
 * User: kolbusz
 * Date: 08.03.15
 * Time: 14:16
 */
use \Symfony\Component\Form\AbstractType;
use \Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskType extends AbstractType{

    private $mode = 'create';

    public function __construct($mode = 'create'){
        $this->mode = $mode;
    }

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('done', 'checkbox', ['required' => false])
            ->add('priority', 'choice', ['choices' => [0,1,2,3]])
            ->add('category', 'entity', ['class' => 'AppBundle:Category'])
            ->add('assignee', 'entity', ['class' => 'AppBundle:User'])
            ->add('save', 'submit');

        if($this->mode == 'create'){
            $builder->add('content', 'text')
                ->add('dueDate', 'date');
        }else if($this->mode == 'edit'){
            $builder->add('content', 'text', ['disabled' => true])
                ->add('dueDate', 'date', ['disabled' => true]);

        }

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Task',
        ]);
    }

    public function getName(){
        return 'task';
    }
}
