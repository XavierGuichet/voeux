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


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set people
     *
     * @param \XG\PeopleBundle\Entity\People $people
     *
     * @return Reponse
     */
    public function setPeople(\XG\PeopleBundle\Entity\People $people = null)
    {
        $this->people = $people;

        return $this;
    }

    /**
     * Get people
     *
     * @return \XG\PeopleBundle\Entity\People
     */
    public function getPeople()
    {
        return $this->people;
    }

    /**
     * Set questionnaire
     *
     * @param \AppBundle\Entity\Questionnaire $questionnaire
     *
     * @return Reponse
     */
    public function setQuestionnaire(\AppBundle\Entity\Questionnaire $questionnaire = null)
    {
        $this->questionnaire = $questionnaire;

        return $this;
    }

    /**
     * Get questionnaire
     *
     * @return \AppBundle\Entity\Questionnaire
     */
    public function getQuestionnaire()
    {
        return $this->questionnaire;
    }

    /**
     * Set question
     *
     * @param \AppBundle\Entity\Question $question
     *
     * @return Reponse
     */
    public function setQuestion(\AppBundle\Entity\Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \AppBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set choix
     *
     * @param \AppBundle\Entity\Choix $choix
     *
     * @return Reponse
     */
    public function setChoix(\AppBundle\Entity\Choix $choix = null)
    {
        $this->choix = $choix;

        return $this;
    }

    /**
     * Get choix
     *
     * @return \AppBundle\Entity\Choix
     */
    public function getChoix()
    {
        return $this->choix;
    }
}
