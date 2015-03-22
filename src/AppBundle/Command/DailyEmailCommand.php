<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\User;
use \DateTime;


class DailyEmailCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('email:daily')
            ->setDescription('Send email with tasks for next day to each user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $users = $em->getRepository('AppBundle:User')
        ->findAll();
        foreach($users as $user){
            $tasks = $em->getRepository('AppBundle:Task')->getTasksForNextDay();
            if($tasks){
                $mailer = $this->getContainer()->get('notification_mailer');
                $mailer->createDailyMessage($user, $tasks);
                $mailer->send();
            }
        }
    }
}