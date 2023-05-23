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
        return $this->render('ride/homePage.html.twig', [
            'controller_name' => 'RideController',
        ]);
    }
}
