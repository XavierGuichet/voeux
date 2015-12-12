<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponse
 *
 * @ORM\Table(name="reponse")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReponseRepository")
 */
class Reponse
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\OneToOne(targetEntity="XG\PeopleBundle\Entity\People", cascade={"persist"})
     */
    private $people;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Questionnaire")
     */
    private $questionnaire;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Question")
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Choix")
     */
    private $choix;

}

