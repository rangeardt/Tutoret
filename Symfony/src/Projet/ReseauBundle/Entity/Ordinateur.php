<?php

namespace Projet\ReseauBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ordinateur
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Projet\ReseauBundle\Entity\OrdinateurRepository")
 */
class Ordinateur
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
   * @ORM\ManyToOne(targetEntity="Projet\ReseauBundle\Entity\Salle")
   * @ORM\JoinColumn(nullable=false)
   */
     private $salle;

    /**
     * @var integer
     *
     * @ORM\Column(name="etat", type="integer")
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text",nullable=true)
     */
    private $paquet;



  /**
     * @ORM\OneToOne(targetEntity="Projet\ReseauBundle\Entity\Etudiant")
    */
    private $etudiant;

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
     * @return Ordinateur
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
     * Set salle
     *
     * @param \Projet\ReseauBundle\Entity\Salle $salle
     * @return Ordinateur
     */
    public function setSalle(\Projet\ReseauBundle\Entity\Salle $salle)
    {
        $this->salle = $salle;

        return $this;
    }

    /**
     * Get salle
     *
     * @return \Projet\ReseauBundle\Entity\Salle 
     */
    public function getSalle()
    {
        return $this->salle;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     * @return Ordinateur
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return integer 
     */
    public function getEtat()
    {
        return $this->etat;
    }
    /**
     * Set etudiant
     *
     * @param \Projet\ReseauBundle\Entity\Etudiant $etudiant
     * @return Ordinateur
     */
    public function setEtudiant(\Projet\ReseauBundle\Entity\Etudiant $etudiant = null)
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    /**
     * Get etudiant
     *
     * @return \Projet\ReseauBundle\Entity\Etudiant 
     */
    public function getEtudiant()
    {
        return $this->etudiant;
    }

    /**
     * Set paquet
     *
     * @param string $paquet
     * @return Ordinateur
     */
    public function setPaquet($paquet)
    {
        $this->paquet = $paquet;

        return $this;
    }

    /**
     * Get paquet
     *
     * @return string 
     */
    public function getPaquet()
    {
        return $this->paquet;
    }
}
