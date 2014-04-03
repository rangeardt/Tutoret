<?php

namespace Projet\ReseauBundle\DataFixtures\ORM;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Projet\ReseauBundle\Entity\Etudiant;
class Etudiants implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {

    $liste_Etu=array();
    $numero=array();
    $nom=array();
    $prenom=array();
    $liste_fichier=array(__DIR__.'/A22014.csv',__DIR__.'/AS2014.csv',__DIR__.'/LP2014.csv');
    $cpt=0;
    foreach ($liste_fichier as $key => $nom_fichier) {
   
		$fichier = fopen($nom_fichier, "r"); //Ouverture du fichier en lecture
		while (!feof($fichier))
		{	//tant qu'on est pas a la fin du fichier :
			// On recupere toute la ligne
			$uneLigne = fgets($fichier, 4096);
				//On met dans un tableau les differentes valeurs trouvés (ici séparées par un ';')
			$tableauValeurs = explode(';', $uneLigne);
			if(!empty($tableauValeurs) && isset($tableauValeurs[1]) && isset($tableauValeurs[2]) && isset($tableauValeurs[0])){
					$nom[$cpt]=$tableauValeurs[1];
					$prenom[$cpt]=$tableauValeurs[2];
					$numero[$cpt]=$tableauValeurs[0];
					$cpt++;
			}

		}
	 }

    for( $i=0;$i<$cpt;$i++){
       	$liste_Etu[$i]=new Etudiant();
       	$liste_Etu[$i]->setNumero($numero[$i]);
       	$liste_Etu[$i]->setNom($nom[$i]);
     	$liste_Etu[$i]->setPrenom($prenom[$i]);
    	$liste_Etu[$i]->setImage(null);
    	$manager->persist($liste_Etu[$i]);
    }
    $manager->flush();
  }
}
