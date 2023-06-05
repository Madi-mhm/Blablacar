<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Car;
use App\Entity\Ride;
use App\Entity\Rule;
use App\Form\ProfileModificationType;
use App\Form\CreateAnnounceType;
use App\Form\CarModificationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;






class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function profile(Request $request, EntityManagerInterface $entityManager): Response
    {

        $userRepo = $entityManager->getRepository(User::class);
        $userId = $this->getUser()->getId();
        $user = $userRepo->find($userId);        


        return $this->render('profile/index.html.twig', [
            'user' => $user,
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

    #[Route('/profile/carModification', name: 'app_carModification')]
    public function carModification(Request $request, EntityManagerInterface $entityManager): Response
    {

        // Identify user's ID for future actions 
        $userRepo = $entityManager->getRepository(User::class);
        $user = $userRepo->find($this->getUser()->getId());

        $car = new Car();
        $form = $this->createForm(carModificationType::class, $car);
        $form->handleRequest($request);

        return $this->render('profile/carModification.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/profile/createAnnounce', name: 'app_createAnnounce')]
    public function index(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $ride = new Ride();

        $form = $this->createForm(CreateAnnounceType::class, $ride);

		// Ecoute la soumission du formulaire
		$form->handleRequest($request);

		// Condition valide lorsque le formulaire est soumis et valide
        
		// Persiste les données du formulaire dans l'entité Demo
        // $ride = $form->getData();
        
        // $ride->setCreated(new \DateTime());
        
        // Exécuter la logique que vous souhaitez
        // par exemple enregistrer la nouvelle entité en base de données


        
        if($form->isSubmitted() && $form->isValid()){

            $ride = $form->getData();

          
            $ride->setCreated(new \DateTime());

             

            $userId = $this->getUser()->getId();
            $driver = $entityManagerInterface->getRepository(User::class)->find($userId);
            $ride->setDriver($driver);

            $entityManagerInterface->persist($ride);
            $entityManagerInterface->flush();
        }


        return $this->render('profile/createAnnounce.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}

