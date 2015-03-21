<?php

 namespace AppBundle\Controller;

 use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 use Symfony\Component\HttpFoundation\Request;
 use Symfony\Component\HttpFoundation\Response;
 use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
 use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
 use AppBundle\Entity\Category;
 use AppBundle\Form\Type\CategoryType;
 use Symfony\Component\Security\Core\Exception\AccessDeniedException;

 class CategoryController extends Controller {

    /**
     * @Route("/categories", name="category_index")
     * @Template()
     */
    public function indexAction() {
       $entityManager = $this->getDoctrine()->getManager();
       $categories = $entityManager->getRepository('AppBundle:Category')->findBy(array('createdBy'=>$this->getUser()));
       return $this->render('category/index.html.twig', ['categories' => $categories]);
    }

    /**
     * @Route("/categories/add", name="category_add")
     * @Template()
     */
    public function addAction(Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $category = new Category();
        $user = $this->getUser();
        $category->setCreatedBy($user);

        $form = $this->createForm(new CategoryType(), $category);

        if ($form->handleRequest($request)->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
            return $this->redirect($this->generateUrl('category_index'));
        }

        return $this->render('category/add.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/categories/{id}/edit", name="category_edit")
     * @Template()
     */
    public function editAction(Category $category, Request $request) {
        $user = $this->getUser();

        if($user != $category->getCreatedBy()){
            throw new AccessDeniedException("Cannot edit this category");
        }
        
       $form = $this->createForm(new CategoryType(), $category);
       if ($form->handleRequest($request)->isValid()) {
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($category);
          $entityManager->flush();
          return $this->redirect($this->generateUrl('category_index'));
       }
       return $this->render('category/edit.html.twig', ['form' => $form->createView()]);
    }

 }
