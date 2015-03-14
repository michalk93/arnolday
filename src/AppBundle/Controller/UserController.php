<?php

 namespace AppBundle\Controller;

 use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
 use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
 use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 use Symfony\Component\HttpFoundation\Request;
 use AppBundle\Entity\User;
 use AppBundle\Form\Type\UserType;
 use Symfony\Component\HttpFoundation\Response;

 class UserController extends Controller {

    /**
     * @Route("/users", name="user_index")
     */
    public function indexAction() {
       $entityManager = $this->getDoctrine()->getManager();
       $users = $entityManager->getRepository('AppBundle:User')->findAll();
       return $this->render('user/index.html.twig', [
                   'users' => $users]);
    }

    /**
     * @Route("/users/add/", name="user_add")
     */
    public function addAction(Request $request) {
       $user = new User();
       $form = $this->createForm(new UserType(), $user);

       if ($form->handleRequest($request)->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($user);
          $em->flush();
          return $this->redirect($this->generateUrl('user_index'));
       }

       return $this->render('user/add.html.twig', [
                   'form' => $form->createView()]);
    }

    /**
     * @Route("/users/{id}/edit", name="user_edit")
     */
    public function editAction(User $user, Request $request) {
       $form = $this->createForm(new UserType(), $user);

       if ($form->handleRequest($request)->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->flush();
          return $this->redirect($this->generateUrl('user_index'));
       }

       return $this->render('/user/edit.html.twig', [
                   'form' => $form->createView()]);
    }

 }
 