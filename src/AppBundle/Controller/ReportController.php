<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    /**
     * @Route("/tasks/pdf/assigned", name="tasks-assigned-pdf")
     */
    public function generateAssignedTasksPDFAction(){
        $user = $this->getUser();
        $html = $this->renderView(':report:assignedTasks.html.twig',['user' => $user, 'tasks' => $user->getAssignedTasks()]);
        $pdfGenerator = $this->get('spraed.pdf.generator');
        $pdf = $pdfGenerator->generatePDF($html);
        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="report-'.$user->getName().'.pdf"'
        ]);
    }

    /**
     * @Route("/tasks/pdf/created", name="tasks-created-pdf")
     */
    public function generateCreatedTasksPDFAction(){
        $user = $this->getUser();
        $html = $this->renderView(':report:createdTasks.html.twig',['user' => $user, 'tasks' => $user->getCreatedTasks()]);
        $pdfGenerator = $this->get('spraed.pdf.generator');
        $pdf = $pdfGenerator->generatePDF($html);
        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="report-'.$user->getName().'.pdf"'
        ]);
    }

    /**
     * @Route("tasks/html", name="tasks-html")
     */
    public function generateHTMLAction(){
        $user = $this->getUser();
        return $this->render('taskReportTemplate.html.twig',['user' => $user, 'tasks' => $user->getAssignedTasks()]);
    }
}
