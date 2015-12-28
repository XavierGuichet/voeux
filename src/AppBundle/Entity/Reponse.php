<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Reponses",inversedBy="listreponses")
     * @Assert\NotNull()
     */
    private $reponses;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Question")
     * @Assert\NotNull()
     */
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Choix")
     * @Assert\NotNull()
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
     * Set reponses
     *
     * @param \AppBundle\Entity\Reponses $reponses
     *
     * @return Reponse
     */
    public function setReponses(\AppBundle\Entity\Reponses $reponses = null)
    {
        $this->reponses = $reponses;

        return $this;
    }

    /**
     * Get reponses
     *
     * @return \AppBundle\Entity\Reponses
     */
    public function getReponses()
    {
        return $this->reponses;
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

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Reponse
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }
}
