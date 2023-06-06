<?php

namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Ride;
use App\Entity\User;
use App\Entity\Rule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class RideController extends AbstractController
{
    #[Route('/', name: 'app_ride')]
    public function homePage(): Response
    {
        return $this->render('pages/homePage.html.twig', [
            'controller_name' => 'Home Page',
        ]);
    }

    #[Route('/booking', name: 'booking_page')]
    public function booking(EntityManagerInterface $entityManager, Security $security): Response
    {
        $productsRepository = $entityManager->getRepository(Ride::class);
        $products = $productsRepository->findAll();
        $currentUser = $security->getUser()->getId();


        foreach ($products as $product) {
            $createdString = $product->getCreated()->format('d-m-Y');
            $product->createdString = $createdString;
        }

        return $this->render('pages/booking.html.twig', [
            'controller_name' => 'Booking Page',
            'products' => $products,
            'currentUser' => $currentUser,
        ]);
    }   

    #[Route('/details/announce/{id}', name: 'details_page')]     
    public function details(EntityManagerInterface $entityManager, string $id): Response              
    {
        $productsRepository = $entityManager->getRepository(Ride::class);
        $product = $productsRepository->findOneBy(['id' => $id]);

        if(!$product){
            return $this->render('components/cardsDetails.html.twig');
        }

        
        $createdString = $product->getCreated()->format('l. d F');
        $product->createdString = $createdString;
        

        return $this->render('components/cardsDetails.html.twig', [
            'controller_name' => 'details_page',
            'product' => $product,                        
        ]);

        
    }

}
