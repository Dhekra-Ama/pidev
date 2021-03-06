<?php

namespace App\Controller;

use App\Entity\Fichier;
use App\Form\FichierType;
use App\Repository\FichierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FichierController extends AbstractController
{
    /**
     * @Route("/fichier", name="fichier")
     */
    public function index(): Response
    {
        return $this->render('fichier/index.html.twig', [
            'controller_name' => 'FichierController',
        ]);
    }

    /**
     * @Route("/removeFich/{id}", name="remove_fichier")
     */
    public function remove($id)
    {

        $em = $this->getDoctrine()->getManager();
        $fichier = $this->getDoctrine()->getRepository(Fichier::class)->find($id);
        $em->remove($fichier);
        $em->flush();
        return $this->redirectToRoute('fichier_show');
    }
    /**
     * @Route("/listfichier", name="fichier_show")
     */
    public function afficheFichier()
    {
        $fichiers=$this->getDoctrine()->getRepository(Fichier::class)->findAll();
        return $this->render("fichier/ShowFich.html.twig",array("fichiers"=>$fichiers));

    }
    /**
     * @Route("/fichier/new", name="fichier_create")
     */
    public function CreerFichier (Request $request){
        $fichier=new fichier();
        $form=$this->createForm(FichierType::class,$fichier);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($fichier);
            $em->flush();
            return $this->redirectToRoute("fichier_show");
        }
        return $this->render('fichier/create.html.twig' , ['form' =>$form->createView()]);
    }
    /**
     * @Route("/fichier/{id}/edit", name="edit_fichier")
     */
    function Update(FichierRepository $repository, $id,Request $request)
    {
        $fichier = $repository->find($id);
        $form = $this->createForm(FichierType::class, $fichier);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fichier);
            $em->flush();

            return $this->redirectToRoute("fichier_show");


        }
        return $this->render('fichier/UpdateFich.html.twig', ['form' => $form->createView()]);}


}
