<?php

namespace Projet\ReseauBundle\DataFixtures\ORM;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Projet\ReseauBundle\Entity\Application;
class Applications implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {

    $liste_App=array();

    $nom=array();
    $iden=array();
    $nom_fichier=__DIR__.'/Application.csv';
   $cpt=0;
		$fichier = fopen($nom_fichier, "r"); //Ouverture du fichier en lecture
		while (!feof($fichier))
		{	//tant qu'on est pas a la fin du fichier :
			// On recupere toute la ligne
			$uneLigne = fgets($fichier, 4096);
				//On met dans un tableau les differentes valeurs trouvés (ici séparées par un ';')
			$tableauValeurs = explode(';', $uneLigne);
		if(!empty($tableauValeurs) && isset($tableauValeurs[1]) && isset($tableauValeurs[0])){
      
					$nom[$cpt]=$tableauValeurs[0];
					$iden[$cpt]=$tableauValeurs[1];
					$cpt++;
			}

		}
	 

    for( $i=0;$i<$cpt;$i++){
       	$liste_App[$i]=new Application();
       	$liste_App[$i]->setNom($nom[$i]);
     	$liste_App[$i]-> setIdentifiant($iden[$i]);
    	$manager->persist($liste_App[$i]);
    }
    $manager->flush();
  }
}
