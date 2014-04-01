<?php

namespace Projet\ReseauBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ConfigApplication
{
  /**
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="Projet\ReseauBundle\Entity\Ordinateur")
   */
  private $post;

  /**
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="Projet\ReseauBundle\Entity\Application")
   */
  private $Application;

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
     * Set configpost
     *
     * @param \Projet\ReseauBundle\Entity\ConfigPost $configpost
     * @return ConfigApplication
     */
    public function setConfigpost(\Projet\ReseauBundle\Entity\ConfigPost $configpost)
    {
        $this->configpost = $configpost;

        return $this;
    }

    /**
     * Get configpost
     *
     * @return \Projet\ReseauBundle\Entity\ConfigPost 
     */
    public function getConfigpost()
    {
        return $this->configpost;
    }

    /**
     * Set Application
     *
     * @param \Projet\ReseauBundle\Entity\Application $application
     * @return ConfigApplication
     */
    public function setApplication(\Projet\ReseauBundle\Entity\Application $application)
    {
        $this->Application = $application;

        return $this;
    }

    /**
     * Get Application
     *
     * @return \Projet\ReseauBundle\Entity\Application 
     */
    public function getApplication()
    {
        return $this->Application;
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
}
