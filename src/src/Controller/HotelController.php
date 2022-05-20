<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Repository\HotelRepository;
use App\service\HotelService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HotelController extends AbstractController
{
    #[Route('/hotels', name: 'app_hotels')]
    public function index(HotelRepository $repository): Response
    {
        $hotels = $repository->findAll();
        return $this->render('hotel/index.html.twig', [
            'hotels' => $hotels,
        ]);
    }

    #[Route('/hotel/view/{id}', name: 'app_hotel_view')]
    public function view(Hotel $hotel): Response
    {
        return $this->render('hotel/view.html.twig', [
            'hotel' => $hotel,
        ]);
    }

    #[Route('/hotel/create', name: 'app_hotel_create')]
    public function create(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        if ($request->isMethod("POST")) {
            $name = $request->get('name');
            $numOfStars = $request->get('num');

            $hotel = new Hotel();
            $hotel->setName($name);
            $hotel->setNumOfStars($numOfStars);

            $errors = $validator->validate($hotel);
            if (count($errors) > 0) {
                $errorsString = (string)$errors;
                return new Response($errorsString);
            }
            $entityManager->persist($hotel);
            $entityManager->flush();
        }
        return $this->render('hotel/create.html.twig', [
        ]);
    }

    #[Route('/hotel/edit/{id}', name: 'app_hotel_edit')]
    public function edit(Hotel $hotel, Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        if ($request->isMethod("POST")) {
            $name = $request->get('name');
            $numOfStars = $request->get('num');


            $hotel->setName($name);
            $hotel->setNumOfStars($numOfStars);

            $errors = $validator->validate($hotel);
            if (count($errors) > 0) {
                $errorsString = (string)$errors;
                return new Response($errorsString);
            }
            $entityManager->persist($hotel);
            $entityManager->flush();
        }
        return $this->render('hotel/edit.html.twig', ['hotel' => $hotel
        ]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/hotel/delete/{id}', name: 'app_hotel_delete')]
    public function delete(Hotel $hotel, HotelRepository $repository): Response
    {
        $repository->remove($hotel);
        return $this->redirectToRoute("app_hotels");
    }

    /**
     * @throws Exception
     */
    #[Route('/hotel/search/', name: 'app_hotel_search')]
    public function search(Request $request, HotelService $hotelService): Response
    {
        $hotels = [];
        if ($request->isMethod('POST')) {
            $hotels = $hotelService->searchByName($request->get('name'));
        }
        return $this->render('hotel/search.html.twig', [
            'hotels' => $hotels,
        ]);
    }
}
