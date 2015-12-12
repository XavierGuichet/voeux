<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VoeuxPropose
 *
 * @ORM\Table(name="voeux_propose")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VoeuxProposeRepository")
 */
class VoeuxPropose
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
     * @var \DateTime
     *
     * @ORM\Column(name="DateEnvoi", type="datetime")
     */
    private $dateEnvoi;

    /**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Questionnaire")
     */
    private $questionnaire;

    /**
	 * @ORM\OneToOne(targetEntity="XG\PeopleBundle\Entity\People", cascade={"persist"})
     */
    private $people;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ContenuMail")
     */
    private $contenuMail;


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
     * Set dateEnvoi
     *
     * @param \DateTime $dateEnvoi
     *
     * @return VoeuxPropose
     */
    public function setDateEnvoi($dateEnvoi)
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    /**
     * Get dateEnvoi
     *
     * @return \DateTime
     */
    public function getDateEnvoi()
    {
        return $this->dateEnvoi;
    }

    /**
     * Set groupeChoixId
     *
     * @param integer $groupeChoixId
     *
     * @return VoeuxPropose
     */
    public function setGroupeChoixId($groupeChoixId)
    {
        $this->groupeChoixId = $groupeChoixId;

        return $this;
    }

    /**
     * Get groupeChoixId
     *
     * @return int
     */
    public function getGroupeChoixId()
    {
        return $this->groupeChoixId;
    }

    /**
     * Set peopleId
     *
     * @param integer $peopleId
     *
     * @return VoeuxPropose
     */
    public function setPeopleId($peopleId)
    {
        $this->peopleId = $peopleId;

        return $this;
    }

    /**
     * Get peopleId
     *
     * @return int
     */
    public function getPeopleId()
    {
        return $this->peopleId;
    }

    /**
     * Set contenuMailId
     *
     * @param integer $contenuMailId
     *
     * @return VoeuxPropose
     */
    public function setContenuMailId($contenuMailId)
    {
        $this->contenuMailId = $contenuMailId;

        return $this;
    }

    /**
     * Get contenuMailId
     *
     * @return int
     */
    public function getContenuMailId()
    {
        return $this->contenuMailId;
    }
}

