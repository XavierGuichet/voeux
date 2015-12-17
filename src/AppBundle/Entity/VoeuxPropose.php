<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
/**
 * VoeuxPropose
 *
 * @ORM\Table(name="voeux_propose")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VoeuxProposeRepository")
 */
class VoeuxPropose
{
	public function __construct() {
		$this->dateEnvoi = new \Datetime();		
		$this->isAnswered = 0;		
	}
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
     * 
     * @Assert\DateTime()
     */
    private $dateEnvoi;
    
    
    /**
     * @var string
     * @ORM\Column(name="envoyeurEmail", type="string", length=255)
     * @Assert\Email(message="Cette adresse e-mail n'est pas valide.")
     */
    private $envoyeurEmail;

    /**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Questionnaire")
	 * 
	 * @Assert\Valid()
     */
    private $questionnaire;

    /**
	 * @ORM\OneToOne(targetEntity="XG\PeopleBundle\Entity\People", cascade={"persist"})
	 * 
	 * @Assert\Valid()
     */
    private $people;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ContenuMail")
     * 
     * @Assert\Valid()
     */
    private $contenuMail;

    /**
     * @var string
     * 
     * @ORM\Column(name="tokenmail", type="text")
     */
    private $tokenmail;

    /**
     * @var boolean
     * 
     * @ORM\Column(name="isanswered", type="boolean")
     */
    private $isAnswered;


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

    /**
     * Set questionnaire
     *
     * @param \AppBundle\Entity\Questionnaire $questionnaire
     *
     * @return VoeuxPropose
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
     * Set people
     *
     * @param \XG\PeopleBundle\Entity\People $people
     *
     * @return VoeuxPropose
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
     * Set contenuMail
     *
     * @param \AppBundle\Entity\ContenuMail $contenuMail
     *
     * @return VoeuxPropose
     */
    public function setContenuMail(\AppBundle\Entity\ContenuMail $contenuMail = null)
    {
        $this->contenuMail = $contenuMail;

        return $this;
    }

    /**
     * Get contenuMail
     *
     * @return \AppBundle\Entity\ContenuMail
     */
    public function getContenuMail()
    {
        return $this->contenuMail;
    }

    /**
     * Set tokenmail
     *
     * @param string $tokenmail
     *
     * @return VoeuxPropose
     */
    public function setTokenmail($tokenmail)
    {
        $this->tokenmail = $tokenmail;

        return $this;
    }

    /**
     * Get tokenmail
     *
     * @return string
     */
    public function getTokenmail()
    {
        return $this->tokenmail;
    }

    /**
     * Set isAnswered
     *
     * @param boolean $isAnswered
     *
     * @return VoeuxPropose
     */
    public function setIsAnswered($isAnswered)
    {
        $this->isAnswered = $isAnswered;

        return $this;
    }

    /**
     * Get isAnswered
     *
     * @return boolean
     */
    public function getIsAnswered()
    {
        return $this->isAnswered;
    }

    /**
     * Set envoyeurEmail
     *
     * @param string $envoyeurEmail
     *
     * @return VoeuxPropose
     */
    public function setEnvoyeurEmail($envoyeurEmail)
    {
        $this->envoyeurEmail = $envoyeurEmail;

        return $this;
    }

    /**
     * Get envoyeurEmail
     *
     * @return string
     */
    public function getEnvoyeurEmail()
    {
        return $this->envoyeurEmail;
    }
}
