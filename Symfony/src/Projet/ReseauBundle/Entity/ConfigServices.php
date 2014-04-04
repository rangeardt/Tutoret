<?php

namespace Projet\ReseauBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ConfigServices
{
  /**
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="Projet\ReseauBundle\Entity\Ordinateur")
   */
  private $post;

  /**
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="Projet\ReseauBundle\Entity\Service")
   */
  private $service;

  /**
   * @ORM\Column()
   */
  private $etat; // Ici j'ai un attribut de relation « niveau »



    /**
     * Set etat
     *
     * @param string $etat
     * @return ConfigApplication
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string 
     */
    public function getEtat()
    {
        return $this->etat;
    }

    

    /**
     * Set post
     *
     * @param \Projet\ReseauBundle\Entity\Ordinateur $post
     * @return ConfigApplication
     */
    public function setPost(\Projet\ReseauBundle\Entity\Ordinateur $post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \Projet\ReseauBundle\Entity\Ordinateur 
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set service
     *
     * @param \Projet\ReseauBundle\Entity\Service $service
     * @return ConfigServices
     */
    public function setService(\Projet\ReseauBundle\Entity\Service $service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \Projet\ReseauBundle\Entity\Service 
     */
    public function getService()
    {
        return $this->service;
    }
}
