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

}
