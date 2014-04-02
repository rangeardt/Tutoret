<?php

namespace Projet\ReseauBundle\DataFixtures\ORM;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Projet\ReseauBundle\Entity\Ordinateur;
use Projet\ReseauBundle\Entity\Salle;
use \Datetime;
class OrdinateursSalles implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {

    $liste_Salle=array();
    $nom=array();
    $iden=array();
    $madate=new Datetime();
    $nbpcallumer=array();
    $nbpctotal=array();
    $nbpcoccuper=array();
    $fsalle=__DIR__.'/Salle.csv';

    $liste_Ordi=array();
    $nom=array();
    $nomSalle=array();
    $fordi=__DIR__.'/Ordinateur.csv';

    $fichier = fopen($fsalle, "r"); //Ouverture du fichier en lecture
    while (!feof($fichier))
    { //tant qu'on est pas a la fin du fichier :
        // On recupere toute la ligne
      $uneLigne = fgets($fichier, 4096);

        //On met dans un tableau les differentes valeurs trouvés (ici séparées par un ';')
      $tableauValeurs = explode(';', $uneLigne);
      if(!empty($tableauValeurs) && isset($tableauValeurs[1]) && isset($tableauValeurs[2]) && isset($tableauValeurs[0]) && isset($tableauValeurs[3]) && isset($tableauValeurs[4])){
        $liste_Salle[$tableauValeurs[0]]=new Salle();
        $liste_Salle[$tableauValeurs[0]]->setNom($tableauValeurs[0]);
        $liste_Salle[$tableauValeurs[0]]->setIdentificateur($tableauValeurs[1]);  
        $liste_Salle[$tableauValeurs[0]]->setNbpctotal($tableauValeurs[2]);
        $liste_Salle[$tableauValeurs[0]]->setNbpcallume($tableauValeurs[3]);
        $liste_Salle[$tableauValeurs[0]]->setNbpcoccuper($tableauValeurs[4]);
        $liste_Salle[$tableauValeurs[0]]->setDate($madate);
      }
    }

    foreach($liste_Salle as $i=>$v){
      $manager->persist($v);
    }
   $cpt=0;
    $f1 = fopen($fordi, "r"); //Ouverture du fichier en lecture
		while (!feof($f1))
		{	//tant qu'on est pas a la fin du fichier :
			// On recupere toute la ligne
			$uneLigne = fgets($f1, 4096);
			//On met dans un tableau les differentes valeurs trouvés (ici séparées par un ';')
			$tableauValeurs = explode(';', $uneLigne);
			if(!empty($tableauValeurs) && isset($tableauValeurs[1]) && isset($tableauValeurs[0])){
					$nomSalle[$cpt]=$tableauValeurs[0];
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
     foreach($nomSalle as $i => $n)
    {

      $liste_Ordi[$i]->setSalle($liste_Salle[$n]); 
      $liste_Ordi[$i]->setEtudiant(null);
      $liste_Ordi[$i]->setEtat(0);
      $liste_Ordi[$i]->setPaquet(null);
      $manager->persist($liste_Ordi[$i]);
    }

    $manager->flush();
  }
}
