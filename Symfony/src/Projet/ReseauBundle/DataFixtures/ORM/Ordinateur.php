<?php

namespace Projet\ReseauBundle\DataFixtures\ORM;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Projet\ReseauBundle\Entity\Ordinateur;
use Projet\ReseauBundle\Entity\Salle;
use \Datetime;
class Ordinateurs implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    $liste_Ordi=array();
    $nom=array();
    $idsalle=array();
    $nom_fichier=__DIR__.'/Ordinateur.csv';
    $cpt=0;
    $fichier = fopen($nom_fichier, "r"); //Ouverture du fichier en lecture
		while (!feof($fichier))
		{	//tant qu'on est pas a la fin du fichier :
			// On recupere toute la ligne
			$uneLigne = fgets($fichier, 4096);
			//On met dans un tableau les differentes valeurs trouvés (ici séparées par un ';')
			$tableauValeurs = explode(';', $uneLigne);
			if(!empty($tableauValeurs) && isset($tableauValeurs[1]) && isset($tableauValeurs[0])){
					$idsalle[$cpt]=$tableauValeurs[0];
					$nom[$cpt]=$tableauValeurs[1];
					$cpt++;
			}
		// la ligne est finie donc on passe a la ligne suivante de la boucle While
		}


    for( $i=0;$i<$cpt;$i++){
       $liste_Ordi[$i]=new Ordinateur();
    }
    foreach($nom as $i => $nom)
    {
      $liste_Ordi[$i]->setNom($nom);  
    }
     foreach($idsalle as $i => $n)
    {

      $liste_Ordi[$i]->setSalle($id);  
      $liste_Ordi[$i]->setEtudiant(null);
      $manager->persist($liste_Ordi[$i]);
    }
    $manager->flush();
  }
}
