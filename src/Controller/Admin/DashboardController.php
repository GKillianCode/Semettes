<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Booking;
use App\Entity\ExceptionalClosedSlot;
use App\Entity\MeetingRoom;
use App\Entity\WeekSlot;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    // #[IsGranted('ROLE_SUPER_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Semettes');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Semaine type', 'fa fa-calendar', WeekSlot::class);
        yield MenuItem::linkToCrud('Utilisateur', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Réservations', 'fa fa-calendar', Booking::class);
        yield MenuItem::linkToCrud('Fermetures exceptionnelles', 'fa fa-eye-slash', ExceptionalClosedSlot::class);
        yield MenuItem::linkToCrud('Salles', 'fa fa-city', MeetingRoom::class);
    }
}
