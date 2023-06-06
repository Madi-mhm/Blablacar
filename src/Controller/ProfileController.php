<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Car;
use App\Entity\Ride;
use App\Entity\Rule;
use App\Form\ProfileModificationType;
use App\Form\CreateAnnounceType;
use App\Form\CarRulesType;
use App\Form\CarModificationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Security;


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
    public function createAnnounce(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $ride = new Ride();

        $form = $this->createForm(CreateAnnounceType::class, $ride);

		// Ecoute la soumission du formulaire
		$form->handleRequest($request);

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

    #[Route('/profile/carRules', name: 'app_carRules')]
    public function carRules(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $rule = new Rule();

        $form = $this->createForm(carRulesType::class, $rule);

		// Ecoute la soumission du formulaire
		$form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $rule = $form->getData();
           
            $userId = $this->getUser()->getId();
            $author = $entityManagerInterface->getRepository(User::class)->find($userId);
            $rule->setAuthor($author);


            $entityManagerInterface->persist($rule);
            $entityManagerInterface->flush();
        }

        return $this->render('profile/carRules.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
    // #[Route('/profile/myAnnounces', name: 'app_myAnnounces')]
    // public function myAnnounces(Request $request, EntityManagerInterface $entityManagerInterface): Response
    // {

    //     $user = $this->getUser();
        
    //     $announceRepo = $entityManagerInterface->getRepository(Ride::class);
    //     $announces = $announceRepo->findBy(['driver' => $user]);

       
    //     return $this->render('profile/myAnnounces.html.twig', [
    //         'controller_name' => 'Booking Page',
    //         'announces' => $announces,
    //     ]);
        
    // }


    #[Route('/profile/myAnnounces', name: 'app_myAnnounces')]
    public function myAnnounce(EntityManagerInterface $entityManager, Security $security): Response
    {
        $currentUser = $security->getUser()->getId();

        $productsRepository = $entityManager->getRepository(Ride::class);
        $products = $productsRepository->findAll();

        foreach ($products as $product) {
            $createdString = $product->getCreated()->format('d-m-Y');
            $product->createdString = $createdString;
        }

        return $this->render('profile/myAnnounces.html.twig', [
            'controller_name' => 'myAnnounce Page',
            'products' => $products,
            'currentUser' => $currentUser,
        ]);
    }   

}

