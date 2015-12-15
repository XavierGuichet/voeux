<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Reponses
 *
 * @ORM\Table(name="reponses")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReponsesRepository")
 */
class Reponses
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Reponse",mappedBy="reponses", cascade={"remove", "persist"})
     */
    private $listreponses;
    
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
     * Constructor
     */
    public function __construct()
    {
        $this->listreponses = new ArrayCollection();
    }

    /**
     * Set people
     *
     * @param \XG\PeopleBundle\Entity\People $people
     *
     * @return Reponses
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
     * @return Reponses
     */
    public function setQuestionnaire(\AppBundle\Entity\Questionnaire $questionnaire = null)
    {
        $this->questionnaire = $questionnaire;
		$this->listreponses->clear();			
			foreach($questionnaire->getQuestions() as $key => $question) {
				$reponse = new Reponse();
				$reponse->setQuestion($question->getQuestion());
				$this->addListreponse($reponse);
			}
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
     * Add listreponse
     *
     * @param \AppBundle\Entity\Reponse $listreponse
     *
     * @return Reponses
     */
    public function addListreponse(\AppBundle\Entity\Reponse $listreponse)
    {
        $this->listreponses[] = $listreponse;

        return $this;
    }

    /**
     * Remove listreponse
     *
     * @param \AppBundle\Entity\Reponse $listreponse
     */
    public function removeListreponse(\AppBundle\Entity\Reponse $listreponse)
    {
        $this->listreponses->removeElement($listreponse);
    }

    /**
     * Get listreponses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getListreponses()
    {
        return $this->listreponses;
    }
}
