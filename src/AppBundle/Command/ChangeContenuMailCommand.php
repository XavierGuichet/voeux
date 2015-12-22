<?php

/**
 * Description of TaskCommand
 *
 * @author pinacolada
 */
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeContenuMailCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('task:ChangeTexteMail')
            ->setDescription('Task command that change texte mail in BDD')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<comment>Running Task command...</comment>');

        try {
            $em = $this->getContainer()->get('doctrine.orm.entity_manager');

            $repo = $em->getRepository('AppBundle\Entity\ContenuMail');

            $find = $repo->findTexteWithStrong();

            if($find) {
              $output->writeln('<comment>Texte trouvé : '.$find->getContenuTxt().'</comment>');
              $find->setContenuTxt("Cette année Koba et ses filiales souhaitent<br/> vous présenter des voeux personnalisés.<br/> <strong>Des voeux qui s’appuient<br/> sur ce que vous aimez.</strong>");
              $output->writeln('<info>Texte changé pour : '.$find->getContenuTxt().'</info>');
              $em->persist($find);
              $em->flush();


            }
            else $output->writeln('<error>Texte introuvable</error>');

        } catch (\Exception $e) {
            $output->writeln('<error>ERROR</error>'.$e->getMessage());
        }

        $output->writeln('<comment>Task done!</comment>');
    }
}
