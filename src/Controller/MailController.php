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
        $name = $request->request->get('name');
        $location = $request->request->get('location');
        $date = $request->request->get('date');
        $message = $request->request->get('message');

        $dateFormatted = date_create($date);
        $newDate = date_format($dateFormatted, 'd.m.Y H:i');

        if($this->isCsrfTokenValid('booking-request', $submittedToken) and $email !== null) {

            $email = (new Email())
                ->from('no-reply@madnesscrunch.de')
                ->to('booking@madnesscrunch.de')
                ->replyTo('booking@madnesscrunch.de')
                ->subject('Buchungsanfrage')
                ->text("Anfrage von: $name ($email)\n")
                ->text("Datum: $newDate Uhr\n")
                ->text("Location: $location\n")
                ->text("Nachricht:\n $message")
            ;

            $mailer->send($email);
            $this->addFlash("success","E-Mail wurde versendet!");
        }




        return $this->redirectToRoute('app_index');
    }

}