<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\MeetingRoom;
use App\Repository\BookingRepository;
use App\Repository\MeetingRoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', []);
    }

    #[Route('/booking', name: 'home_booking')]
    public function booking(
        MeetingRoomRepository $meetingRoomRepo,
        EntityManagerInterface $entityManager
    ): Response {

        if (count($_POST) > 0) {
            $basket = json_decode($_POST['basket']);
            $firstname = htmlentities($_POST['firstname']);
            $lastname = htmlentities($_POST['name']);
            $phone = htmlentities($_POST['tel']);
            $email = htmlentities($_POST['email']);
            $bookingId = substr(md5(uniqid()), 0, 10);

            foreach ($basket as $basketDetail) {
                $booking = new Booking();
                $booking->setStartTime(new \DateTime($basketDetail->slot->start));
                $booking->setEndTime(new \DateTime($basketDetail->slot->end));
                $booking->setMeetingRoom($meetingRoomRepo->findOneById(htmlentities($basketDetail->room)));
                $booking->setBookingId($bookingId);
                $booking->setFirstname($firstname);
                $booking->setLastname($lastname);
                $booking->setPhone($phone);
                $booking->setEmail($email);

                $entityManager->persist($booking);
                $entityManager->flush($booking);
            }

            return $this->redirectToRoute('home_index');
        }



        return $this->render('home/booking_form.html.twig', ['data' => 'Hello']);
    }
}
