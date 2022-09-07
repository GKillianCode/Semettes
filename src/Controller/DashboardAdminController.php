<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use App\Repository\MeetingRoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    public function calendar(int $id): Response
    {
        return $this->render('dashboard_admin/calendar.html.twig', ['roomId' => $id]);
    }

    // #[IsGranted('ROLE_ADMIN')]
    #[Route('/admindashboard/{id}/deletebooking/{bookingid}', name: 'app_dashboard_delete')]
    public function bookingDelete(
        int $id,
        int $bookingid,
        BookingRepository $bookingRepository
    ): Response
    {
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
    ): Response
    {
        $booking = $bookingRepository->findOneById($bookingid);
        $apiResponse = new Response($serializer->serialize($booking, 'json', ['groups'=>['booking']]));

        return $apiResponse;
    }

    // #[IsGranted('ROLE_ADMIN')]
    #[Route('/admindashboard/{id}/updatebooking/{bookingid}', name: 'app_dashboard_update')]
    public function bookingUpdate(
        int $id,
        int $bookingid,
        BookingRepository $bookingRepository,
        EntityManagerInterface $em
    ): Response
    {
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

    // #[IsGranted('ROLE_ADMIN')]
    #[Route('/admindashboard/{id}/addbooking', name: 'app_dashboard_booking_add')]
    public function bookingAdd(
        int $id,
        BookingRepository $bookingRepository,
        MeetingRoomRepository $meetingRoomRepository,
        EntityManagerInterface $em,
        Request $request
    ):Response
    {
        $requestData = $request->request;
        $firstname=$requestData->get('firstname');
        $lastname=$requestData->get('name');
        $phone=$requestData->get('tel');
        $email=$requestData->get('email');

        $bookingId=substr(md5(uniqid()), 0, 10);

        $booking=new Booking();
        $booking->setStartTime(new \DateTime( json_decode($requestData->get('slot'))->start ));
        $booking->setEndTime(new \DateTime( json_decode($requestData->get('slot'))->end ));
        $booking->setMeetingRoom($meetingRoomRepository->findOneById($id));
        $booking->setBookingId($bookingId);
        $booking->setFirstname($firstname);
        $booking->setLastname($lastname);
        $booking->setPhone($phone);
        $booking->setEmail($email);
        
        $em->persist($booking);
        $em->flush($booking);

        return new Response(json_encode(json_decode($requestData->get('slot'))));
        // return $this->redirectToRoute('home_index');
        // return $this->redirectToRoute('app_dashboard_admin', ['id' => $id]);
    }
}
