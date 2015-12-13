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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Choix")
     */
    private $choixs;
    /**
     * Constructor
     */
    public function __construct()
    {
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
