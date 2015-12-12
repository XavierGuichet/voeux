<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuestionRepository")
 */
class Question
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
     * @var int
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Questionnaire")
     */
    private $questionnaire;

    /**
     * @var int
     *
     * @ORM\Column(name="ordre", type="integer")
     */
    private $ordre;

    /**
     * @var int
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Choix")
     */
    private $choixs;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questionnaire = new \Doctrine\Common\Collections\ArrayCollection();
        $this->choixs = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set ordre
     *
     * @param integer $ordre
     *
     * @return Question
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return integer
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Add questionnaire
     *
     * @param \AppBundle\Entity\Questionnaire $questionnaire
     *
     * @return Question
     */
    public function addQuestionnaire(\AppBundle\Entity\Questionnaire $questionnaire)
    {
        $this->questionnaire[] = $questionnaire;

        return $this;
    }

    /**
     * Remove questionnaire
     *
     * @param \AppBundle\Entity\Questionnaire $questionnaire
     */
    public function removeQuestionnaire(\AppBundle\Entity\Questionnaire $questionnaire)
    {
        $this->questionnaire->removeElement($questionnaire);
    }

    /**
     * Get questionnaire
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestionnaire()
    {
        return $this->questionnaire;
    }

    /**
     * Add choix
     *
     * @param \AppBundle\Entity\Choix $choix
     *
     * @return Question
     */
    public function addChoix(\AppBundle\Entity\Choix $choix)
    {
        $this->choixs[] = $choix;

        return $this;
    }

    /**
     * Remove choix
     *
     * @param \AppBundle\Entity\Choix $choix
     */
    public function removeChoix(\AppBundle\Entity\Choix $choix)
    {
        $this->choixs->removeElement($choix);
    }

    /**
     * Get choixs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChoixs()
    {
        return $this->choixs;
    }
}
