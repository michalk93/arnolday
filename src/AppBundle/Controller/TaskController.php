<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\Type\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class TaskController extends Controller
{
    /**
     * @Route("tasks", name="task_index")
     */
    public function indexAction(){
        $tasks = $this->getDoctrine()->getRepository("AppBundle:Task")->findBy(array('createdBy'=>$this->getUser()));
        return $this->render('task/index.html.twig', ['tasks' => $tasks]);
    }

    /**
     * @Route("/tasks/{id}", name="tasks_show")
     *
     */
    public function showAction(Task $task) {
        $user = $this->getUser();
        if($user != $task->getCreatedBy()) {
            throw new AccessDeniedException();
        }

        return $this->render('task/show.html.twig', ['task'=> $task]);
    }

    /**
     * @Route("/tasks/add", name="task_add")
     *
     */
    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $task = new Task();
        $user = $this->getUser();
        $task->setCreatedBy($user);
        $form = $this->createForm(new TaskType(), $task);

        if($form->handleRequest($request)->isValid()){
            $em->persist($task);
            $em->flush();
            return $this->redirect($this->generateUrl('task_index'));
        }

        return $this->render('task/add.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     *
     */
    public function editAction(Task $task, Request $request)
    {
        $user = $this->getUser();

        if($user != $task->getCreatedBy()) {
            return new Response("Cannot edit this task");
        }

        $form = $this->createForm(new TaskType(), $task);
        if($form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirect($this->generateUrl('task_index'));
        }

        return $this->render('task/edit.html.twig', ['form' => $form->createView()]);
    }




}
