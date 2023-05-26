<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER', statusCode: 423), Route('/schedule')]
class ScheduleController extends AbstractController
{
    #[Route('/', name: 'schedule', methods: ['GET'])]
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->render('schedule/index.html.twig', [
            'daysCount' => date('t'),
            'clients'   => $clientRepository->findBy(['user' => $this->getUser()]),
        ]);
    }
}
