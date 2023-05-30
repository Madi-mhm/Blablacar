<?php

namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Ride;
use App\Entity\User;
use App\Entity\Rule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RideController extends AbstractController
{
    #[Route('/', name: 'app_ride')]
    public function index(): Response
    {
        return $this->render('pages/homePage.html.twig', [
            'controller_name' => 'Home Page',
        ]);
    }

    #[Route('/booking', name: 'booking_page')]
    public function booking(EntityManagerInterface $entityManager): Response
    {
        $productsRepository = $entityManager->getRepository(Ride::class);
        $products = $productsRepository->findAll();

        return $this->render('pages/booking.html.twig', [
            'controller_name' => 'Booking Page',
            'products' => $products,
        ]);
    }

    #[Route('/publish', name: 'publish_page')]
    public function publish(): Response
    {
        return $this->render('pages/publish.html.twig', [
            'controller_name' => 'Publish Page',
        ]);
    }

    #[Route('/login', name: 'login_page')]
    public function login(): Response
    {
        return $this->render('pages/login.html.twig', [
            'controller_name' => 'Login Page',
        ]);
    }



}

