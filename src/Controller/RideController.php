<?php

namespace App\Controller;

use App\Entity\Ride;
use App\Entity\User;
use App\Entity\Rule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use App\Form\EditAnnounceType;
use Symfony\Component\HttpFoundation\Request;





class RideController extends AbstractController
{
    #[Route('/', name: 'app_ride')]
    public function homePage(): Response
    {
        return $this->render('pages/homePage.html.twig', [
            'controller_name' => 'Home Page',
        ]);
    }


    #[Route('/announce/delete/{id}', name: 'app_announceDelete')]
    public function DeleteCards(EntityManagerInterface $manager, string $id, UrlGeneratorInterface $urlGenerator ): Response
    { 
        $rideRepo = $manager->getRepository(Ride::class);
        $ride = $rideRepo->find($id);

    
        $manager->remove($ride);
        $manager->flush();
        
        return new RedirectResponse($urlGenerator->generate('booking_page'));
    }

    #[Route('/announce/edit/{id}', name: 'app_announceUpdate')]
    public function updateCards(EntityManagerInterface $manager, Request $request , string $id, UrlGeneratorInterface $urlGenerator ): Response
    { 
        $rideRepo = $manager->getRepository(Ride::class);
        $ride = $rideRepo->find($id);

        $form = $this->createForm(EditAnnounceType::class, $ride);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // Get the submitted form data
            $formData = $form->getData();

            // Update the user's profile with the new data 
            $ride->setDeparture($formData->getDeparture());
            $ride->setDestination($formData->getDestination());
            $ride->setSeats($formData->getSeats());
            $ride->setPrice($formData->getPrice());
            $ride->setDate($formData->getDate());

            $ride->getRules()->clear();

            foreach($formData->getRules() as $rule){
                $ride->addRule($ride);

            }

            $manager->flush();

            return $this->redirectToRoute('booking_page');


        }
        
        return $this->render('pages/editAnnounce.html.twig', [
            'form' => $form->createView(),
            'ride' => $ride,
        ]);

        
    }
        
    



}
