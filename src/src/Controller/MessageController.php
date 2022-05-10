<?php

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MessageController extends AbstractController
{

    #[Route('/messages', name: 'app_messages')]
    public function index(MessageRepository $repository): Response
    {
        $messages = $repository->findAll();
        return $this->render('message/index.html.twig', [
            'msg' => $messages,
        ]);
    }


    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/message/create', name: 'app_message_create')]
    public function create(Request $request, MessageRepository $repository, ValidatorInterface $validator): Response
    {
        if ($request->isMethod('POST')) {

            $text = $request->get('msg');

            $message = new Message();
            $message->setText($text);
            $errors = $validator->validate($message);
            if (count($errors) > 0) {

                $errorsString = (string)$errors;

                return new Response($errorsString);

            }
        $repository->add($message);
        }
        return $this->render('message/create.html.twig', [
        ]);
    }

    #[Route('/message/edit/{id}', name: 'app_message_edit')]
    public function edit(Request $request, EntityManagerInterface $manager, Message $message,ValidatorInterface $validator): Response
    {
        if ($request->isMethod('POST')) {

            $text = $request->get('msg');

            $message->setText($text);

            $errors = $validator->validate($message);
            if (count($errors) > 0) {

                $errorsString = (string)$errors;

                return new Response($errorsString);

            }

            $manager->flush();

        }
        return $this->render('message/edit.html.twig', ['msg' => $message
        ]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/message/delete/{id}', name: 'app_message_delete')]
    public function delete(Message $message, MessageRepository $repository): Response
    {
        $repository->remove($message);
        return $this->redirectToRoute("app_messages");
    }
}
