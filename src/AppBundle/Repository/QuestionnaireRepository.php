<?php

namespace AppBundle\Repository;

/**
 * QuestionnaireRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class QuestionnaireRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAllQuestionnairesComplet() {
        $qb = $this->createQueryBuilder('a')
                   ->leftJoin('a.questions', 'QuestionnaireQuestion')
                   ->addSelect('QuestionnaireQuestion')
                   ->leftJoin('QuestionnaireQuestion.question', 'Question')
                   ->addSelect('Question')
                   ->leftJoin('Question.choixs', 'Choix')
                   ->addSelect('Choix')
                   ->add('orderBy','a.id ASC, QuestionnaireQuestion.ordre ASC');
                
        return $qb->getQuery()->getResult();
    }
    public function getSelectList() {
        $qb = $this->createQueryBuilder('a')
                   ->leftJoin('a.questions', 'QuestionnaireQuestion')
                   ->addSelect('QuestionnaireQuestion')
                   ->leftJoin('QuestionnaireQuestion.question', 'Question')
                   ->addSelect('Question')
                   ->leftJoin('Question.choixs', 'Choix')
                   ->addSelect('Choix')
                   ->add('orderBy','a.id ASC, QuestionnaireQuestion.ordre ASC');
                
        return $qb; 
    }
}
