<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RideController extends AbstractController
{
    #[Route('/', name: 'app_ride')]
    public function index(): Response
    {
        return $this->render('pages/homePage.html.twig', [
            'controller_name' => 'RideController',
        ]);
    }

    #[Route('/booking', name: 'booking_page')]
    public function booking(): Response
    {
        return $this->render('pages/booking.html.twig', [
            'controller_name' => 'RideController',
        ]);
    }

    #[Route('/publish', name: 'publish_page')]
    public function publish(): Response
    {
        return $this->render('pages/publish.html.twig', [
            'controller_name' => 'RideController',
        ]);
    }

    #[Route('/login', name: 'login_page')]
    public function login(): Response
    {
        return $this->render('pages/login.html.twig', [
            'controller_name' => 'RideController',
        ]);
    }


}

