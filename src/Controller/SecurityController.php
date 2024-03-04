<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\TexterInterface;
use Symfony\Component\Serializer\SerializerInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/{_locale<%locales%>}/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/api/open/message', name: 'app_notif_message', methods: ['POST'])]
    public function notif_sms(Request $request, SerializerInterface $serializer, TexterInterface $texter): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        try {

            $sms = new SmsMessage(
                // the phone number to send the SMS message to
                $data["phone"],
                // the message
                $data["message"]
            );

            $sentMessage = $texter->send($sms);
            return new JsonResponse(null, Response::HTTP_OK);
        } catch (Exception $ex) {
            $jsonDocument = $serializer->serialize(["message" => $ex->getMessage()], 'json');
            return new JsonResponse($jsonDocument, Response::HTTP_BAD_REQUEST);
        }
    }
}
