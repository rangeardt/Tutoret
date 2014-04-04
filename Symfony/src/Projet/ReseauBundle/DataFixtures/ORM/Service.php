<?php

namespace Projet\ReseauBundle\DataFixtures\ORM;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Projet\ReseauBundle\Entity\Service;
class Services implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {

    $liste_Service=array();
    $cpt=4;
    $nom=array("web","ftp","imprimante","cfengine");
    $port=array("80","21",null,null);
    $type=array("getPageAccueil","banner","cups","cfengine");
	 

    for( $i=0;$i<$cpt;$i++){
       	$liste_Service[$i]=new Service();
       	$liste_Service[$i]->setNom($nom[$i]);
     	  $liste_Service[$i]->setPort($port[$i]);
        $liste_Service[$i]->setType($type[$i]);
    	  $manager->persist($liste_Service[$i]);
    }
    $manager->flush();
  }
}
