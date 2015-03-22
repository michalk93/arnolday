<?php

namespace AppBundle\EventListener;

use ADesigns\CalendarBundle\Event\CalendarEvent;
use ADesigns\CalendarBundle\Entity\EventEntity;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Security\Core\SecurityContext;

class CalendarEventListener {
    private $em;
    private $router;
    private $securityContext;

    function __construct(EntityManager $em, Router $router, SecurityContext $securityContext)
    {
        $this->em=$em;
        $this->router=$router;
        $this->securityContext = $securityContext;
    }

    public function loadEvents(CalendarEvent $calendarEvent)
    {
        $this->generateCalendarData($calendarEvent, "createdBy");
        $this->generateCalendarData($calendarEvent, "assignee");
    }

    private function generateCalendarData(CalendarEvent $calendarEvent, $column){
        $startDate = $calendarEvent->getStartDatetime();
        $endDate = $calendarEvent->getEndDatetime();
        $user = $this->securityContext->getToken()->getUser();
        $class = "";
        $tasks = null;
        if($column == "assignee"){
            $tasks = $this->em->getRepository('AppBundle:Task')->getAssignedTasks($startDate, $endDate, $user);
            $class = "task-assigned";
        }else if($column == "createdBy"){
            $tasks = $this->em->getRepository('AppBundle:Task')->getCreatedTasks($startDate, $endDate, $user);
            $class = "task-created";
        }


        foreach($tasks as $task) {
            $eventEntity = new EventEntity($task->getName(), $task->getDueDate(), null, true);
            $eventEntity->setAllDay(true);
            $eventEntity->setBgColor($task->getCategory()->getColor());
            $eventEntity->setFgColor('#FFFFFF');
            $eventEntity->setUrl($this->router->generate('tasks_show',array('id' => $task->getId())));
            $eventEntity->setCssClass($class);

            $calendarEvent->addEvent($eventEntity);
        }
    }

}