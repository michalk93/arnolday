<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\Type\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TaskController extends Controller
{
    /**
     * @Route("task/index", name="task-index")
     */
    public function indexAction(){
        $tasks = $this->getDoctrine()->getRepository("AppBundle:Task")->findAll();
        return $this->render('AppBundle:task:index.html.twig', ['tasks' => $tasks]);

    }
    /**
     * @Route("/task/add", name="task-add")
     * @Template("AppBundle:task:addTask.html.twig")
     */
    public function addTaskAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $task = new Task();
        $task->setCreatedBy($em->find("AppBundle:User", 1));
        $form = $this->createForm(new TaskType(), $task);

        if($form->handleRequest($request)->isValid()){
            $em->persist($task);
            $em->flush();
            return $this->render('AppBundle:task:index.html.twig');
        }

        return $this->render('add.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/task/edit/{id}", name="task-edit")
     * @Template("AppBundle:task:editTask.html.twig")
     */
    public function editTaskAction(Task $task, Request $request)
    {
        $form = $this->createForm(new TaskType(), $task);
        if($form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->render('AppBundle:task:index.html.twig');
        }

        return $this->render('edit.html.twig', ['form' => $form->createView()]);
    }




}
