<?php

namespace App\Controller;

use Symfony\Component\Validator\Constraints\DateTime;
use App\Repository\BookingRepository;
use App\Repository\MeetingRoomRepository;
use App\Repository\WeekSlotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends AbstractController
{
    #[Route('/api/weekslots', name: 'show_weekslot')]
    public function show(
        WeekSlotRepository $weekslotRepo,
        MeetingRoomRepository $meetingRoomRepo,
        BookingRepository $bookingRepo,
    ): Response {
        $weekSlots = $weekslotRepo->findAll();
        $meetingRooms = $meetingRoomRepo->findAll();
        $bookings = $bookingRepo->findFromTodayOnward();
        $begin =  new \DateTime(); // now();
        $end =  new \DateTime();
        $end->modify('+60 day');
        $response = [];
        for ($i = $begin; $i <= $end; date_modify($i, '+1 day')) {
            $morning = new \DateTime($i->format('Y') . '-' . $i->format('m') . '-' . $i->format('d') . ' 08:00:00');
            $response[] = [
                'start' => $morning->format('Y-m-d H:i:s'),
                'end' => date('Y-m-d H:i:s', strtotime($morning->format('Y-m-d H:i:s') . '+4 hours')),
                'extendedProps' => [
                    'room' => ['room1'],
                    'isClickable' => true
                ],
            ];
            $afternoon = new \DateTime($i->format('Y') . '-' . $i->format('m') . '-' . $i->format('d') . ' 13:00:00');
            $response[] = [
                'start' => $afternoon->format('Y-m-d H:i:s'),
                'end' => date('Y-m-d H:i:s', strtotime($afternoon->format('Y-m-d H:i:s') . '+4 hours')),
                'extendedProps' => [
                    'room' => ['room1'],
                    'isClickable' => true
                ],
            ];
        }
        
        $apiResponse = new JsonResponse($response, 200, []);
        return $apiResponse;
    }
}
