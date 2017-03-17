<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class CleanOldNotesCommand
 * @package AppBundle\Command
 */
class CleanOldNotesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:note-clean')
            ->addArgument('amount', InputArgument::REQUIRED, 'Amount removed Notes')
            ->setDescription('Clean old Notes')
            ->setHelp('This command remove several oldest Notes')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $notes = $em->getRepository('AppBundle:Note')->findOldestNotes($input->getArgument('amount'));

        if(!$notes) {
            $output->writeln('Have no any Notes');
            return;
        }

        foreach ($notes as $note) {
            $em->remove($note);
        }

        $em->flush();
    }
}