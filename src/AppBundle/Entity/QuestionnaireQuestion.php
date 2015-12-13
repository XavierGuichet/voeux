<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuestionnaireQuestion
 *
 * @ORM\Table(name="questionnaire_question")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuestionnaireQuestionRepository")
 */
class QuestionnaireQuestion
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
     * @ORM\Column(name="Ordre", type="integer")
     */
    private $ordre;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Questionnaire",inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $questionnaire;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Question")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;

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
     * @return QuestionnaireQuestion
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
     * Set questionnaire
     *
     * @param \AppBundle\Entity\Questionnaire $questionnaire
     *
     * @return QuestionnaireQuestion
     */
    public function setQuestionnaire(\AppBundle\Entity\Questionnaire $questionnaire)
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
     * @return QuestionnaireQuestion
     */
    public function setQuestion(\AppBundle\Entity\Question $question)
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
}
