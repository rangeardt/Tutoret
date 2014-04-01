<?php

namespace Projet\ReseauBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Projet\ReseauBundle\Entity\Salle;
use \Datetime;
class Salles implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    $liste_Salle=array();
    $nom=array();
    $iden=array();
    $madate=new Datetime();
    $nbpcallumer=array();
    $nbpctotal=array();
    $nbpcoccuper=array();
    $nom_fichier=__DIR__.'/Salle.csv';
    $cpt=0;
    $fichier = fopen($nom_fichier, "r"); //Ouverture du fichier en lecture
    while (!feof($fichier))
    { //tant qu'on est pas a la fin du fichier :
        // On recupere toute la ligne
      $uneLigne = fgets($fichier, 4096);

        //On met dans un tableau les differentes valeurs trouvés (ici séparées par un ';')
      $tableauValeurs = explode(';', $uneLigne);
      if(!empty($tableauValeurs) && isset($tableauValeurs[1]) && isset($tableauValeurs[2]) && isset($tableauValeurs[0]) && isset($tableauValeurs[3]) && isset($tableauValeurs[4])){
        $nom[$cpt]=$tableauValeurs[0];
        $iden[$cpt]=$tableauValeurs[1];
        $nbpctotal[$cpt]=$tableauValeurs[2];
        $nbpcallumer[$cpt]=$tableauValeurs[3];
        $nbpcoccuper[$cpt]=$tableauValeurs[4];
        $cpt++;
      }
    }
    for( $i=0;$i<$cpt;$i++){
       $liste_Salle[$i]=new Salle();
    }
    foreach($nom as $i => $nom)
    {
      $liste_Salle[$i]->setNom($nom);  
    }
     foreach($iden as $i => $id)
    {
      $liste_Salle[$i]->setIdentificateur($id);  
    }
     foreach($nbpcallumer as $i => $a)
    {
      $liste_Salle[$i]->setNbpcallume($a);  
    }
     foreach($nbpctotal as $i => $t)
    {
      $liste_Salle[$i]->setNbpctotal($t);  
    }
     foreach($nbpcoccuper as $i => $o)
    {
      $liste_Salle[$i]->setNbpcoccuper($o);  
      $liste_Salle[$i]->setDate($madate);
      $manager->persist($liste_Salle[$i]);
    }
    $manager->flush();
  }
}