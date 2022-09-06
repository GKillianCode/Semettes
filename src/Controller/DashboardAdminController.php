<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonDecode;

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

    // #[IsGranted('ROLE_ADMIN')]
    #[Route('/admindashboard/{id}/deletebooking/{bookingid}', name: 'app_dashboard_delete')]
    public function bookingDelete(
        int $id,
        int $bookingid,
        BookingRepository $bookingRepository
    ): Response {
        $booking = $bookingRepository->findOneById($bookingid);
        $bookingRepository->remove($booking, true);

        return $this->redirectToRoute('app_dashboard_admin', ['id' => $id]);
    }

    // #[IsGranted('ROLE_ADMIN')]
    #[Route('/admindashboard/getdata/{bookingid}', name: 'app_dashboard_get_data')]
    public function bookingGetData(
        int $bookingid,
        BookingRepository $bookingRepository,
        SerializerInterface $serializer,
    ): Response {
        $booking = $bookingRepository->findOneById($bookingid);

        $apiResponse = new Response($serializer->serialize($booking, 'json', ['groups' => ['booking']]));

        return $apiResponse;
    }


    // #[IsGranted('ROLE_ADMIN')]
    #[Route('/admindashboard/{id}/updatebooking/{bookingid}', name: 'app_dashboard_update')]
    public function bookingUpdate(
        int $id,
        int $bookingid,
        BookingRepository $bookingRepository,
        EntityManagerInterface $em,
        Request $request
    ): Response {


        $content = json_decode($request->getContent())[0];

        $booking = $bookingRepository->findOneById($bookingid);
        $booking->setBookingId($content->reservation);
        $booking->setFirstname($content->firstname);
        $booking->setLastname($content->lastname);
        $booking->setPhone($content->phone);
        $booking->setEmail($content->email);

        $em->persist($booking);
        $em->flush($booking);

        return new JsonResponse($content->reservation);
    }

    // #[IsGranted('ROLE_ADMIN')]
    #[Route('/admindashboard/{id}/addbooking', name: 'app_dashboard_booking_add')]
    public function bookingAdd(
        int $id,
        int $bookingid,
        BookingRepository $bookingRepository,
        EntityManagerInterface $em
    ): Response {
        $firstname = htmlentities($_POST['firstname']);
        $lastname = htmlentities($_POST['lastname']);
        $phone = htmlentities($_POST['phone']);
        $email = htmlentities($_POST['email']);

        $booking = $bookingRepository->findOneById($bookingid);
        $booking->setFirstname = $firstname;
        $booking->setLastname = $lastname;
        $booking->setPhone = $phone;
        $booking->setEmail = $email;

        $em->persist($booking);
        $em->flush($booking);

        return $this->redirectToRoute('app_dashboard_admin', ['id' => $id]);
    }
}
