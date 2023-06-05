<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;



class BookingController extends AbstractController
{
    
    #[Route('/offer/detail', name: 'app_offer_detail')]
    public function offerDetail(EntityManagerInterface $entityManager): Response
    {

        return $this->render('app/offerDetail.html.twig', [
            'controller_name' => "Détail d'une offre",
        ]);
    }


    // #[Route('/offers/chambery', name: 'app_offers_chambery')]
    // public function offersChambery(): Response
    // {
    //     return $this->render('app/offersChambery.html.twig', [
    //         'controller_name' => "Les offres à Chambery",
    //     ]);
    // }



}
