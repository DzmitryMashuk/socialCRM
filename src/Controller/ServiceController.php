<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Service;
use App\Entity\User;
use App\Form\ServiceType;
use App\Repository\ClientRepository;
use App\Repository\ServiceCatalogRepository;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(User::ROLE_USER, statusCode: 423), Route('/service')]
class ServiceController extends AbstractController
{
    #[Route('/', name: 'service', methods: ['GET'])]
    public function index(
        ServiceRepository $serviceRepository,
        ServiceCatalogRepository $serviceCatalogRepository,
        ClientRepository $clientRepository
    ): Response
    {
        return $this->render('service/index.html.twig', [
            'services'        => $serviceRepository->findBy(['user' => $this->getUser()]),
            'clients'         => $clientRepository->findBy(['user' => $this->getUser()]),
            'serviceCatalogs' => $serviceCatalogRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'service_create', methods: ['GET', 'POST'])]
    public function create(
        Request $request,
        ServiceRepository $serviceRepository,
        ServiceCatalogRepository $serviceCatalogRepository,
        ClientRepository $clientRepository
    ): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientId = $request->request->get('client_id');
            $client = $clientRepository->find($clientId);
            $service->setClient($client);

            $serviceCatalogId = $request->request->get('service_catalog_id');
            $serviceCatalog = $serviceCatalogRepository->find($serviceCatalogId);
            $service->setServiceCatalog($serviceCatalog);

            $service->setUser($this->getUser());
            $serviceRepository->save($service, true);

            return $this->redirectToRoute('service', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('service/new.html.twig', [
            'service'         => $service,
            'form'            => $form,
            'clients'         => $clientRepository->findBy(['user' => $this->getUser()]),
            'serviceCatalogs' => $serviceCatalogRepository->findBy([], ['serviceCatalogGroup' => 'ASC']),
            'refererUrl'      => $request->headers->get('referer'),
        ]);
    }

    #[Route('/{id}/edit', name: 'service_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Service $service,
        ServiceRepository $serviceRepository,
        ServiceCatalogRepository $serviceCatalogRepository,
        ClientRepository $clientRepository
    ): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceRepository->save($service, true);

            return $this->redirectToRoute('service', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('service/edit.html.twig', [
            'service'         => $service,
            'form'            => $form,
            'clients'         => $clientRepository->findBy(['user' => $this->getUser()]),
            'serviceCatalogs' => $serviceCatalogRepository->findBy([], ['serviceCatalogGroup' => 'ASC']),
            'refererUrl'      => $request->headers->get('referer'),
        ]);
    }

    #[Route('/{id}/delete', name: 'service_delete', methods: ['GET'])]
    public function delete(Service $service, ServiceRepository $serviceRepository): Response
    {
        $serviceRepository->remove($service, true);
        return $this->redirectToRoute('service', [], Response::HTTP_SEE_OTHER);
    }

    #[IsGranted(User::ROLE_ADMIN, statusCode: 423), Route('/downloadCSV', name: 'service_download_csv', methods: ['GET'])]
    public function downloadCSV(Request $request, ServiceRepository $serviceRepository): JsonResponse
    {
        $services =  $serviceRepository->findByUserAndServiceDate(
            (int)$request->query->get('userId'),
            $request->query->get('serviceDateFrom'),
            $request->query->get('serviceDateTo')
        );

        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename=Услуги-' . date('d-m-Y') . '.csv');

        $handle = fopen('php://output', 'w');

        $delimiter = ';';

        $head = [
            'id',
            'Гражданин',
            'Услуга',
            'Дата услуги',
            'Причины',
        ];

        fputcsv($handle, $head, $delimiter);

        foreach ($services as $service) {
            fputcsv($handle, [
                $service->getId(),
                $service->getClient()->getFullName(),
                $service->getServiceCatalog()->getName(),
                $service->getServiceDate()->format('Y-m-d'),
                $service->getNote(),
            ], $delimiter);
        }

        fclose($handle);

        die();
    }
}
