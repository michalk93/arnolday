<?php

 namespace AppBundle\Controller;

 use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 use Symfony\Component\HttpFoundation\Request;
 use Symfony\Component\HttpFoundation\Response;
 use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
 use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
 use AppBundle\Entity\Category;
 use AppBundle\Form\Type\CategoryType;

 class CategoryController extends Controller {

    /**
     * @Route("/categories")
     * @Template()
     */
    public function listAction() {
       $entityManager = $this->getDoctrine()->getManager();
       $categories = $entityManager->getRepository('AppBundle:Category')->findAll();
       return $this->render('AppBundle:category:list.html.twig', ['categories' => $categories]);
    }

    /**
     * @Route("/categories/add", name="category-add")
     * @Template()
     */
    public function addAction(Request $request) {
       $entityManager = $this->getDoctrine()->getManager();
       $user = $entityManager->find('AppBundle:User', 1);
       $category = new Category();
       $category->setCreatedBy($user);
       $form = $this->createForm(new CategoryType(), $category);

       if ($form->handleRequest($request)->isValid()) {
          $entityManager->persist($category);
          $entityManager->flush();
          return new Response('Category added!');
       }

       return $this->render('AppBundle:category:add.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/categories/edit/{id}", name="category-edit")
     * @Template()
     */
    public function editAction(Category $category, Request $request) {
       $form = $this->createForm(new CategoryType(), $category);
       if ($form->handleRequest($request)->isValid()) {
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($category);
          $entityManager->flush();
          return new Response('Category edited!');
       }
       return $this->render('AppBundle:category:edit.html.twig', ['form' => $form->createView()]);
    }

 }
