<?php

namespace App\Controller;
use App\Entity\Ride;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;




class BookingController extends AbstractController
{

    #[Route('/booking', name: 'booking_page')]
    public function booking(EntityManagerInterface $entityManager, Security $security): Response
    {
        $productsRepository = $entityManager->getRepository(Ride::class);
        $products = $productsRepository->findAll();
        
        if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // User is authenticated and fully logged in
            $currentUser = $security->getUser()->getId();
        }

        foreach ($products as $product) {
            $createdString = $product->getCreated()->format('d-m-Y');
            $product->createdString = $createdString;
        }

        return $this->render('pages/booking.html.twig', [
            'controller_name' => 'Booking Page',
            'products' => $products,
            'currentUser' => !empty($currentUser) ? $currentUser : null,
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

    #[Route('/offer/contact/{id}', name: 'app_userContact')]
    public function contact(EntityManagerInterface $entityManager, string $id): Response
    {
        $productsRepository = $entityManager->getRepository(Ride::class);
        $product = $productsRepository->findOneBy(['id' => $id]);
        $user = $product->getDriver();

        return $this->render('components/contactInfo.html.twig', [
            'controller_name' => "Détail d'une offre",
            'user' => $user,
            'product' => $product,
        ]);
    }

}
