<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER', statusCode: 423), Route('/client')]
class ClientController extends AbstractController
{
    #[Route('/', name: 'client', methods: ['GET'])]
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findBy(['user' => $this->getUser()]),
        ]);
    }

    #[IsGranted('ROLE_ADMIN', statusCode: 423), Route('/all', name: 'client_admin', methods: ['GET'])]
    public function adminIndex(ClientRepository $clientRepository): Response
    {
        return $this->render('client/admin/index.html.twig', [
            'clients' => $clientRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'client_create', methods: ['GET', 'POST'])]
    public function create(Request $request, ClientRepository $clientRepository): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client->setUser($this->getUser());

            $visitDays = $request->request->get('visit_days');
            $visitDays = array_filter(explode(',', $visitDays), fn($v) => $v !== '');
            $client->setVisitDays($visitDays);

            $clientRepository->save($client, true);

            return $this->redirectToRoute('client', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/new.html.twig', [
            'client'     => $client,
            'form'       => $form,
            'refererUrl' => $request->headers->get('referer'),
        ]);
    }

    #[Route('/{id}/edit', name: 'client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Client $client, ClientRepository $clientRepository): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $visitDays = $request->request->get('visit_days');
            if (!is_null($visitDays)) {
                $visitDays = array_filter(explode(',', $visitDays), fn($v) => $v !== '');
                $client->setVisitDays($visitDays);
            }

            $clientRepository->save($client, true);

            $route = $this->isGranted(User::ROLE_ADMIN, $this->getUser()) ? 'client_admin' : 'client';
            return $this->redirectToRoute($route, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/edit.html.twig', [
            'client'     => $client,
            'form'       => $form,
            'refererUrl' => $request->headers->get('referer'),
        ]);
    }

    #[Route('/{id}/delete', name: 'client_delete', methods: ['GET'])]
    public function delete(Request $request, Client $client, ClientRepository $clientRepository): Response
    {
        $clientRepository->remove($client, true);
        $route = $this->isGranted(User::ROLE_ADMIN, $this->getUser()) ? 'client_admin' : 'client';
        return $this->redirectToRoute($route, [], Response::HTTP_SEE_OTHER);
    }
}
