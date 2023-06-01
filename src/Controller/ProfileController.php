<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileModificationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;



class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function profile(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }



    #[Route('/profile/profileModification', name: 'app_profileModification')]
    public function profileModification(Request $request,  UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {


        $userRepo = $entityManager->getRepository(User::class);
        $user = $userRepo->find($this->getUser()->getId());
        
        $form = $this->createForm(profileModificationType::class, $user);
        $form->handleRequest($request);




        return $this->render('profile/ProfileModification.html.twig', [
            'profileModificationForm' => $form->createView(),
        ]);
    }
}
