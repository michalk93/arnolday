<?php
namespace AppBundle\Repository;

use \Doctrine\ORM\EntityRepository;
use \DateTime;

class TaskRepository extends EntityRepository 
{
    public function getCreatedTasks($startDate, $endDate, $user){
        return $this->generateBaseQueryBuilder($startDate, $endDate)
            ->andWhere('task.createdBy = :id')
            ->setParameter('id', $user->getId())
            ->getQuery()->getResult();
    }

    public function getAssignedTasks($startDate, $endDate, $user){
        return $this->generateBaseQueryBuilder($startDate, $endDate)
            ->andWhere('task.assignee = :user')
            ->setParameter('user', $user)
            ->getQuery()->getResult();
    }

    private function generateBaseQueryBuilder($startDate, $endDate){
        return $this->getEntityManager()->getRepository('AppBundle:Task')
            ->createQueryBuilder('task')
            ->where('task.dueDate BETWEEN :startDate and :endDate')
            ->setParameter('startDate', $startDate->format('Y-m-d'))
            ->setParameter('endDate', $endDate->format('Y-m-d'));
    }

    public function getTasksForNextDay(){
        $tomorrowDate = new DateTime();
        return $this->getEntityManager()->getRepository('AppBundle:Task')
            ->createQueryBuilder('task')
            ->where('task.dueDate = :tomorrow')
            ->setParameter('tomorrow', $tomorrowDate->format('Y-m-d'))
            ->getQuery()->getResult();
    }
}