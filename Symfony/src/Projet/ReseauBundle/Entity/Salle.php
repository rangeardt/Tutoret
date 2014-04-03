<?php

namespace Projet\ReseauBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Salle
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Projet\ReseauBundle\Entity\SalleRepository")
 */
class Salle
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, unique=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="identificateur", type="string", length=255, unique=true)
     */
    private $identificateur;
  /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbpctotal", type="integer")
     */
    private $nbpctotal;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbpcallume", type="integer")
     */
    private $nbpcallume;
    /**
     * @var integer
     *
     * @ORM\Column(name="nbpcoccuper", type="integer")
     */
    private $nbpcoccuper;

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
     * Set nom
     *
     * @param string $nom
     * @return Salle
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set identificateur
     *
     * @param string $identificateur
     * @return Salle
     */
    public function setIdentificateur($identificateur)
    {
        $this->identificateur = $identificateur;

        return $this;
    }

    /**
     * Get identificateur
     *
     * @return string 
     */
    public function getIdentificateur()
    {
        return $this->identificateur;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Salle
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set nbpctotal
     *
     * @param integer $nbpctotal
     * @return Salle
     */
    public function setNbpctotal($nbpctotal)
    {
        $this->nbpctotal = $nbpctotal;

        return $this;
    }

    /**
     * Get nbpctotal
     *
     * @return integer 
     */
    public function getNbpctotal()
    {
        return $this->nbpctotal;
    }

    /**
     * Set nbpcallume
     *
     * @param integer $nbpcallume
     * @return Salle
     */
    public function setNbpcallume($nbpcallume)
    {
        $this->nbpcallume = $nbpcallume;

        return $this;
    }

    /**
     * Get nbpcallume
     *
     * @return integer 
     */
    public function getNbpcallume()
    {
        return $this->nbpcallume;
    }

    /**
     * Set nbpcoccuper
     *
     * @param integer $nbpcoccuper
     * @return Salle
     */
    public function setNbpcoccuper($nbpcoccuper)
    {
        $this->nbpcoccuper = $nbpcoccuper;

        return $this;
    }

    /**
     * Get nbpcoccuper
     *
     * @return integer 
     */
    public function getNbpcoccuper()
    {
        return $this->nbpcoccuper;
    }
}
