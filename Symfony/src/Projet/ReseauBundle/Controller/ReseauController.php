<?php

namespace Projet\ReseauBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Projet\ReseauBundle\Entity\Salle;
use Projet\ReseauBundle\Entity\ConfigSalle;
use Projet\ReseauBundle\Entity\Ordinateur;
use Projet\ReseauBundle\Form\SalleType;
use Projet\ReseauBundle\Form\ApplicationType;
use Projet\ReseauBundle\Entity\Application;
use Projet\ReseauBundle\Form\OrdinateurType;
use Projet\ReseauBundle\Form\EtudiantType;
use Projet\ReseauBundle\Entity\Etudiant;
use \DateTime;

class  ReseauController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProjetReseauBundle:Reseau:index.html.twig');
    }
    public function serviceAction()
    {
        $service=array(
          array(
            'titre'=>'Aperçu Réseau',
            'desc'=>'Donne un aperçu rapide du réseau ( chaque salle ) ...',
            'route'=>'Projet_reseauGlobal'

            ),
          );
      

        return $this->render('ProjetReseauBundle:Reseau:service.html.twig',array(
          'liste_service'=>$service
        ));
    }
       public function reseauGlobalAction()
    {
        
      $liste = $this->getDoctrine()
                  ->getManager()
                  ->getRepository('ProjetReseauBundle:Salle')
                  ->findAll();
    return $this->render('ProjetReseauBundle:Reseau:reseauGlobal.html.twig', array(
                          'liste_salle' => $liste// C'est ici tout l'intérêt : le contrôleur passe les variables nécessaires au template !
    ));
    }
    public function reseauSalleViewAction($salle)
    {
          $salle = $this->getDoctrine()
                  ->getManager()
                  ->getRepository('ProjetReseauBundle:Salle')
                  ->findOneByNom($salle);
         $liste = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('ProjetReseauBundle:Ordinateur')
                        ->findById($salle->getId());
 $app = $this->getDoctrine()
                  ->getManager()
                  ->getRepository('ProjetReseauBundle:ConfigApplication')
                  ->findAll();

                   $serv = $this->getDoctrine()
                  ->getManager()
                  ->getRepository('ProjetReseauBundle:ConfigServices')
                  ->findAll();
    return $this->render('ProjetReseauBundle:Reseau:reseauSalleView.html.twig', array(
      'salle'=>$salle,
      'liste_post' => $liste,
      'app'=>$app,
      'serv'=>$serv
    ));

    }
    public function reseauPostViewPaquetAction($salle,$post)
    {
          $defaults = $this->getDoctrine()
                  ->getManager()
                  ->getRepository('ProjetReseauBundle:Paquet')
                  ->findAll();
         $rep = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('ProjetReseauBundle:Ordinateur')
                        ->findBySallePost($salle,$post);
    return $this->render('ProjetReseauBundle:Reseau:reseauPostViewPaquet.html.twig', array(
      'defaults'=>$defaults,
      'rep'=>$rep,
       'salle'=>$salle,
    ));

    }

    public function formSalleAction()
    {
      $salle = new Salle();
      $form = $this->createForm(new SalleType, $salle);

      $request = $this->get('request');
      if ($request->getMethod() == 'POST') {
        $form->bind($request);

        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $madate=new datetime();
          $salle->setDate($madate);
          $salle->setNbpctotal(0);
          $salle->setNbpcallume(0);
          $salle->setNbpcoccuper(0);
          $em->persist($salle);
          $em->flush();

          return $this->redirect($this->generateUrl('Projet_admin'));
        }
      }

      return $this->render('ProjetReseauBundle:Reseau:formulaireSalle.html.twig', array(
        'form' => $form->createView(),
      ));
    }


    public function formApplicationAction()
    {
      $appli = new Application();
      $form = $this->createForm(new ApplicationType, $appli);

      $request = $this->get('request');
      if ($request->getMethod() == 'POST') {
        $form->bind($request);

        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($appli);
          $em->flush();

          return $this->redirect($this->generateUrl('Projet_admin'));
        }
      }

      return $this->render('ProjetReseauBundle:Reseau:formulaireApplication.html.twig', array(
        'form' => $form->createView(),
      ));
    }


        public function formOrdinateurAction()
    {
      $ordi = new Ordinateur();
      $form = $this->createForm(new OrdinateurType, $ordi);

      $request = $this->get('request');
      if ($request->getMethod() == 'POST') {
        $form->bind($request);

        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $ordi->setEtat(0);
          $ordi->setEtudiant_id(NULL);
          $em->persist($ordi);
          $em->flush();

          return $this->redirect($this->generateUrl('Projet_admin'));
        }
      }

      return $this->render('ProjetReseauBundle:Reseau:formulaireOrdinateur.html.twig', array(
        'form' => $form->createView(),
      ));
    }

    public function formEtudiantAction()
    {
      $etu = new Etudiant();
      $form = $this->createForm(new EtudiantType, $etu);

      $request = $this->get('request');
      if ($request->getMethod() == 'POST') {
        $form->bind($request);

        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($etu);
          $em->flush();

          return $this->redirect($this->generateUrl('Projet_admin'));
        }
      }

      return $this->render('ProjetReseauBundle:Reseau:formulaireEtudiant.html.twig', array(
        'form' => $form->createView(),
      ));
    }


}
