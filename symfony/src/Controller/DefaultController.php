<?php

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    /**
    * @Route("/")
    */
    public function messages(MessageRepository $messageRepository): JsonResponse
    {
        $messages = $messageRepository->findAll();

        $allMessages = [];

        foreach ($messages as $message) {
            $allMessages[] = $message->getMessage();
        }

        return new JsonResponse(['message_count' => count($messages), 'messages' => $allMessages]);
    }

    /**
    * @Route("/add")
    */
    public function add(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $receivedMessage = $request->query->get('message');

        if (is_string($receivedMessage) && strlen($receivedMessage) > 0) {
            $newMessage = new Message();
            $newMessage->setMessage($receivedMessage);
            $entityManager->persist($newMessage);
            $entityManager->flush();

            return new JsonResponse(['result' => 'message saved']);
        }
        
        return new JsonResponse(['result' => 'something went wrong']);
    }
}
