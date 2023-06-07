<?php

namespace App\Controller;
use App\Entity\Ride;
use App\Entity\Reservation;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;






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

        if(!$product){
            throw $this->createNotFoundException('Product not found');
        }

        $user = $product->getDriver();


        return $this->render('components/contactInfo.html.twig', [
            'controller_name' => "Détail d'une offre",
            'user' => $user,
            'product' => $product,
        ]);
    }


    #[Route('/reservation/{id}', name: 'app_reservation')]
    public function reserveSeat(EntityManagerInterface $entityManager, string $id, UrlGeneratorInterface $urlGenerator ): Response

    {

        $rideRepo = $entityManager->getRepository(Ride::class);
        $ride = $rideRepo->findOneBy(['id' => $id]);

        
        $user = $this->getUser();


        $reservation = new Reservation();
        $reservation->setConfirmed(true);
        $reservation->setRide($ride);
        $reservation->setPassenger($user);

        $entityManager->persist($reservation);
        $entityManager->flush();

        
        return new RedirectResponse($urlGenerator->generate('app_userContact' , ['id' => $id]));
               
    }
}

