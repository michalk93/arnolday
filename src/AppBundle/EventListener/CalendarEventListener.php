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
        $startDate = $calendarEvent->getStartDatetime();
        $endDate = $calendarEvent->getEndDatetime();
        $user = $this->securityContext->getToken()->getUser();
        $userId = $user->getId();
        $request = $calendarEvent->getRequest();
        $filter = $request->get('filter');
        $tasks = $this->em->getRepository('AppBundle:Task')
            ->createQueryBuilder('task')
            ->where('task.dueDate BETWEEN :startDate and :endDate')
            ->andWhere('task.createdBy = :id')
            ->setParameter('startDate', $startDate->format('Y-m-d'))
            ->setParameter('endDate', $endDate->format('Y-m-d'))
            ->setParameter('id', $userId)
            ->getQuery()->getResult();

        foreach($tasks as $task) {
            $eventEntity = new EventEntity($task->getName(), $task->getDueDate(), null, true);
            $eventEntity->setAllDay(true);
            $eventEntity->setBgColor($task->getCategory()->getColor());
            $eventEntity->setFgColor('#FFFFFF');
            $eventEntity->setUrl($this->router->generate('tasks_show',array('id' => $task->getId())));
            $eventEntity->setCssClass('my-custom-class');

            $calendarEvent->addEvent($eventEntity);
        }
    }


}