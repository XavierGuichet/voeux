<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Choix
 *
 * @ORM\Table(name="choix")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChoixRepository")
 */
class Choix
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
     * @var string
     *
     * @ORM\Column(name="imagepath", type="string", length=255,nullable=true)
     */
    private $imagepath;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255,nullable=true)
     */
    private $titre;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set imagepath
     *
     * @param string $imagepath
     *
     * @return Choix
     */
    public function setImagepath($imagepath)
    {
        $this->imagepath = $imagepath;

        return $this;
    }

    /**
     * Get imagepath
     *
     * @return string
     */
    public function getImagepath()
    {
        return $this->imagepath;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Choix
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->choix = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add choix
     *
     * @param \AppBundle\Entity\Choix $choix
     *
     * @return Choix
     */
    public function addChoix(\AppBundle\Entity\Choix $choix)
    {
        $this->choix[] = $choix;

        return $this;
    }

    /**
     * Remove choix
     *
     * @param \AppBundle\Entity\Choix $choix
     */
    public function removeChoix(\AppBundle\Entity\Choix $choix)
    {
        $this->choix->removeElement($choix);
    }

    /**
     * Get choix
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChoix()
    {
        return $this->choix;
    }

    /**
     * Add reponse
     *
     * @param \AppBundle\Entity\Choix $reponse
     *
     * @return Choix
     */
    public function addReponse(\AppBundle\Entity\Choix $reponse)
    {
        $this->reponses[] = $reponse;

        return $this;
    }

    /**
     * Remove reponse
     *
     * @param \AppBundle\Entity\Choix $reponse
     */
    public function removeReponse(\AppBundle\Entity\Choix $reponse)
    {
        $this->reponses->removeElement($reponse);
    }

    /**
     * Get reponses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReponses()
    {
        return $this->reponses;
    }
}
