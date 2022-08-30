<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', []);
    }

    #[Route('/booking', name: 'home_booking', methods: ['POST', 'GET'])]
    public function booking(): Response
    {
        if (count($_POST) > 0){
            dd($_POST);
        }
        return $this->render('home/booking_form.html.twig', ['data'=>'Hello']);
    }
}

