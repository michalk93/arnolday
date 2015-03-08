<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/user/list", name="user_list")
     */
    public function usersListAction()
    {
      $entityManager = $this->getDoctrine()->getManager();
      $users = $entityManager->getRepository('AppBundle:User')->findAll();
      return $this->render('AppBundle:user:list.html.twig', [
        'users' => $users]);

    }

    /**
     * @Route("/user/add/", name="user_add")
     */
    public function addUserAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new UserType(), $user);

        if($form->handleRequest($request)->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($user);
          $em->flush();
          return $this->redirect($this->generateUrl('user_list'));
        }

        return $this->render('AppBundle:user:add.html.twig', [
              'form'=>$form->createView()]);
    }

    /**
     * @Route("/user/edit/{id}", name="user_edit")
     */
    public function editUserAction(User $user, Request $request)
    {
        $form = $this->createForm(new UserType(), $user);

        if($form->handleRequest($request)->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->flush();
          return $this->redirect($this->generateUrl('user_list'));
        }

        return $this->render('AppBundle:user:edit.html.twig', [
              'form'=>$form->createView()]);
    }

}
