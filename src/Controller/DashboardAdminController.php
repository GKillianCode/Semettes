<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardAdminController extends AbstractController
{
    // #[IsGranted('ROLE_ADMIN')]
    #[Route('/admindashboard', name: 'app_room_list_admin')]
    public function index(): Response
    {
        return $this->render('dashboard_admin/index.html.twig');
    }

    // #[IsGranted('ROLE_ADMIN')]
    #[Route('/admindashboard/{id}', name: 'app_dashboard_admin')]
    public function calendar(): Response
    {
        return $this->render('dashboard_admin/calendar.html.twig');
    }
}
