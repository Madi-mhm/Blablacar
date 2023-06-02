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


        if($form->isSubmitted() && $form->isValid()){

            // Get the submitted form data
            $formData = $form->getData();

            // Update the user's profile with the new data 

            $user->setEmail($formData->getEmail());
            $user->setFirstName($formData->getFirstName());
            $user->setLastName($formData->getLastName());
            $user->setPhone($formData->getPhone());

            // If the password field is included in the form, you can update the password as well
            $password = $formData->getPassword();
            if(!empty($password)){
                
                $hashedPassword = $userPasswordHasher->hashPassword($user, $password);
                $user->setPassword($hashedPassword);
            }

            // Save the updated user entity to the database
            $entityManager->flush();

            // Redirect the user to a success page or perform any other desired action
            return $this->redirectToRoute('app_profile');
        }




        return $this->render('profile/ProfileModification.html.twig', [
            'profileModificationForm' => $form->createView(),
        ]);
    }
}
