<?php

namespace App\Controller;

use App\Entity\Attraction;
use App\Repository\AttractionRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AttractionController extends AbstractController
{
    #[Route('/attractions', name: 'app_attraction')]
    public function index(AttractionRepository $repository): Response
    {
        $attractions = $repository->findAll();
        return $this->render('attraction/index.html.twig', [
            'attractions' => $attractions,
        ]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/attraction/create', name: 'app_attraction_create')]
    public function create(Request $request, AttractionRepository $repository): Response
    {
        if ($request->isMethod("POST")) {
            $name = $request->get("name");
            $shortDescription = $request->get("short_description");
            $fullDescription = $request->get("full_description");
            $score = $request->get("score");
            $attraction = new Attraction($name, $shortDescription, $fullDescription, $score);
            $repository->add($attraction);
        }
        return $this->render('attraction/create.html.twig', [
        ]);
    }

    #[Route('/attraction/edit/{id}', name: 'app_attraction_edit')]
    public function edit(Request $request, Attraction $attraction, EntityManagerInterface $manager): Response
    {
        if ($request->isMethod("POST")) {
            $name = $request->get("name");
            $shortDescription = $request->get("short_description");
            $fullDescription = $request->get("full_description");
            $score = $request->get("score");

            $attraction->setName($name);
            $attraction->setShortDescription($shortDescription);
            $attraction->setFullDescription($fullDescription);
            $attraction->setScore($score);
            $attraction->setUpdatedAt(new DateTimeImmutable());
            $manager->flush();
        }
        return $this->render('attraction/edit.html.twig', ['atr' => $attraction
        ]);
    }

    #[Route('/attraction/view/{id}', name: 'app_attraction_view')]
    public function view(Attraction $attraction): Response
    {
        return $this->render('attraction/view.html.twig', [
            'atr' => $attraction
        ]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/attraction/delete/{id}', name: 'app_attraction_delete')]
    public function delete(Attraction $attraction, AttractionRepository $repository): Response
    {
        $repository->remove($attraction);
        return $this->redirectToRoute("app_attraction");
    }
}
