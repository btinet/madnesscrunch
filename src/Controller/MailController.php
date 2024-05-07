<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/email', name: 'email_')]
class MailController extends AbstractController
{

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/email', name: 'send', methods: 'POST')]
    public function sendEmail(MailerInterface $mailer, Request $request, MessageBusInterface $bus): Response
    {
        $submittedToken = $request->request->get('token');
        $email = $request->request->get('email');

        if($this->isCsrfTokenValid('booking-request', $submittedToken) and $email !== null) {

            $email = (new Email())
                ->from('no-reply@madnesscrunch.de')
                ->to($email)
                ->replyTo('booking@madnesscrunch.de')
                ->subject('Time for Symfony Mailer!')
                ->text('Sending emails is fun again!')
                ->html('<p>See Twig integration for better HTML integration!</p>');

            $mailer->send($email);
        }




        return $this->redirectToRoute('app_index');
    }

}