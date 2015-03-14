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
     * @Route("task/index", name="task_index")
     */
    public function indexAction(){
        $tasks = $this->getDoctrine()->getRepository("AppBundle:Task")->findAll();
        return $this->render('task/index.html.twig', ['tasks' => $tasks]);

    }
    /**
     * @Route("/task/add", name="task_add")
     *
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
            return $this->redirect($this->generateUrl('task-index'));
        }

        return $this->render('task/add.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/task/edit/{id}", name="task_edit")
     *
     */
    public function editTaskAction(Task $task, Request $request)
    {
        $form = $this->createForm(new TaskType(), $task);
        if($form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirect($this->generateUrl('task-index'));
        }

        return $this->render('task/edit.html.twig', ['form' => $form->createView()]);
    }




}
