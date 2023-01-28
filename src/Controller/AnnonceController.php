<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Form\AdvertisementType;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    #[Route('/annonces', name: 'app_annonce')]
    public function getAnnonces(AnnonceRepository $repo): Response
    {
        return $this->render('Annonces.html.twig', [
            'controller_name' => 'AnnonceController',
            'annonces' => $repo->findAll()
        ]);
    }

    #[Route('/annonces/ajouter', name: 'add_annonce')]
    public function getForm(Request $request, AnnonceRepository $annonceRepo, EntityManagerInterface $entityManager): Response
    {
        // just set up a fresh $annonce object (remove the example data)
        $annonce = new Annonce();

        $form = $this->createForm(AdvertisementType::class, $annonce);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$annonce` variable has also been updated
            $annonce = $form->getData();
            $annonceRepo->save($annonce);
            $entityManager->persist($annonce);

            return $this->redirectToRoute('add_annonce_success');
        }

        return $this->render('AdvertisementType.html.twig', [
            'form' => $this->createForm(AdvertisementType::class)
        ]);
    }

    #[Route('/annonces/ajouter', name: 'add_annonce_success')]
    public function successForm(): Response
    {
        return $this->render('AdvertisementType.html.twig', [
            'form' => $this->createForm(AdvertisementType::class),
            'annonceAdded' => true
        ]);
    }
}
