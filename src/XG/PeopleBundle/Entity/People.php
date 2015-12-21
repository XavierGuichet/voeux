<?php

namespace XG\PeopleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * People
 *
 * @ORM\Table(name="people")
 * @ORM\Entity(repositoryClass="XG\PeopleBundle\Repository\PeopleRepository")
 * @UniqueEntity(fields="email", message="Cette adresse e-mail existe déjà.")
 */
class People
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
     * @var boolean
     *
     * @ORM\Column(name="ismale", type="boolean")
     */
    private $ismale;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=255)
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom", type="string", length=255)
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="eMail", type="string", length=255, unique=true)
     * @Assert\Email(message="Cette adresse e-mail n'est pas valide.")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse", type="string", length=255)
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="Codepostal", type="string", length=255)
     * @Assert\Length(
     *      max = 5,
     *      maxMessage = "Le Code Postal ne peut pas dépassé {{ limit }} caractères"
     * )
     */
    private $codepostal;

    /**
     * @var string
     *
     * @ORM\Column(name="Ville", type="string", length=255)
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="Societe", type="string", length=255)
     * @Assert\NotBlank(message="Ce champ est obligatoire.")
     */
    private $societe;


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
     * Set ismale
     *
     * @param boolean $ismale
     *
     * @return People
     */
    public function setIsmale($ismale)
    {
        $this->ismale = $ismale;

        return $this;
    }

    /**
     * Get ismale
     *
     * @return boolean
     */
    public function getIsmale()
    {
        return $this->ismale;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return People
     */
    public function setNom($nom)
    {
        $this->nom = mb_strtoupper($nom, 'UTF-8');

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return mb_strtoupper($this->nom, 'UTF-8');
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return People
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return People
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return People
     */
    public function setAdresse($adresse)
    {
        $this->adresse = mb_strtoupper($adresse, 'UTF-8');

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return mb_strtoupper($this->adresse, 'UTF-8');
    }

    /**
     * Set codepostal
     *
     * @param string $codepostal
     *
     * @return People
     */
    public function setCodepostal($codepostal)
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    /**
     * Get codepostal
     *
     * @return string
     */
    public function getCodepostal()
    {
        return $this->codepostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return People
     */
    public function setVille($ville)
    {
        $this->ville = mb_strtoupper($ville);

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return mb_strtoupper($this->ville);
    }

    /**
     * Set societe
     *
     * @param string $societe
     *
     * @return People
     */
    public function setSociete($societe)
    {
        $this->societe = mb_strtoupper($societe, 'UTF-8');

        return $this;
    }

    /**
     * Get societe
     *
     * @return string
     */
    public function getSociete()
    {
        return mb_strtoupper($this->societe, 'UTF-8');
    }
}
