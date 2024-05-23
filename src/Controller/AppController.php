<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Media;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository\RepositoryFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_')]
class AppController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $events = $entityManager->getRepository(Event::class)->findAll();

        return $this->render('app/index.html.twig', [
            'page_title' => 'Konzerte, Booking und mehr',
            'events' => $events
        ]);
    }

    #[Route('/imprint', name: 'imprint')]
    public function imprint(): Response
    {
        return $this->render('app/index.html.twig', [
            'page_title' => 'Impressum'
        ]);
    }

    #[Route('/privacy', name: 'privacy')]
    public function privacy(): Response
    {
        return $this->render('app/index.html.twig', [
            'page_title' => 'Datenschutz'
        ]);
    }

    #[Route('/music', name: 'music')]
    public function music(EntityManagerInterface $entityManager): Response
    {
        $media = $entityManager->getRepository(Media::class)->findAll();

        return $this->render('app/music.html.twig', [
            'page_title' => 'Musik und mehr',
            'media' => $media
        ]);
    }

    #[Route('/pictures', name: 'pictures')]
    public function pictures(): Response
    {

        return $this->render('app/pictures.html.twig', [
            'page_title' => 'Fotos',
        ]);
    }

    #[Route('/press', name: 'press')]
    public function press(): Response
    {
        return $this->render('app/index.html.twig', [
            'page_title' => 'Presse'
        ]);
    }

}
