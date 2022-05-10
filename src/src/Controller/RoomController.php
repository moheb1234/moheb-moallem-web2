<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\Message;
use App\Entity\Room;
use App\Repository\MessageRepository;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RoomController extends AbstractController
{
    #[Route('/rooms', name: 'app_rooms')]
    public function index(RoomRepository $repository): Response
    {
        $rooms = $repository->findAll();
        return $this->render('room/index.html.twig', [
            'rooms' => $rooms,
        ]);
    }

    #[Route('/room/create', name: 'app_room_create')]
    public function create(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $hotelRepository = $entityManager->getRepository(Hotel::class);
        $hotels = $hotelRepository->findAll();

        if ($request->isMethod("POST")) {
            $numOfBeds = $request->get('num_of_bed');
            $hotelId = $request->get('hotel_id');
            $hotel = $hotelRepository->find($hotelId);

            $room = new Room();
            $room->setNumOfBeds($numOfBeds);
            $room->setHotel($hotel);
            $room->setIsEmpty(true);

            $errors = $validator->validate($room);
            if (count($errors) > 0) {
                $errorsString = (string)$errors;
                return new Response($errorsString);
            }
            $entityManager->persist($room);
            $entityManager->flush();
        }
        return $this->render('room/create.html.twig', [
            'hotels' => $hotels,
        ]);
    }

    #[Route('/room/edit/{id}', name: 'app_room_edit')]
    public function edit(Room $room, Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {

        if ($request->isMethod("POST")) {
            $numOfBeds = $request->get('num_of_bed');
            $isEmpty = $request->get('is_empty');

            $room->setNumOfBeds($numOfBeds);

            $errors = $validator->validate($room);
            if (count($errors) > 0) {
                $errorsString = (string)$errors;
                return new Response($errorsString);
            }

            $entityManager->persist($room);
            $entityManager->flush();
        }
        return $this->render('room/edit.html.twig', [
            'room' => $room
        ]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/room/delete/{id}', name: 'app_room_delete')]
    public function delete(Room $room, RoomRepository $repository): Response
    {
        $repository->remove($room);
        return $this->redirectToRoute("app_rooms");
    }
}
