<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContenuMail
 *
 * @ORM\Table(name="contenu_mail")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContenuMailRepository")
 */
class ContenuMail
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
     * @ORM\Column(name="ContenuTxt", type="text")
     */
    private $contenuTxt;


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
     * Set contenuTxt
     *
     * @param string $contenuTxt
     *
     * @return ContenuMail
     */
    public function setContenuTxt($contenuTxt)
    {
        $this->contenuTxt = $contenuTxt;

        return $this;
    }

    /**
     * Get contenuTxt
     *
     * @return string
     */
    public function getContenuTxt()
    {
        return $this->contenuTxt;
    }
}

