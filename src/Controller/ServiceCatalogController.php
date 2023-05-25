<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ServiceCatalog;
use App\Form\ServiceCatalogType;
use App\Repository\ServiceCatalogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN', statusCode: 423), Route('/service/catalog')]
class ServiceCatalogController extends AbstractController
{
    #[Route('/', name: 'service_catalog', methods: ['GET'])]
    public function index(ServiceCatalogRepository $serviceCatalogRepository): Response
    {
        return $this->render('service_catalog/index.html.twig', [
            'service_catalogs' => $serviceCatalogRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'service_catalog_create', methods: ['GET', 'POST'])]
    public function create(Request $request, ServiceCatalogRepository $serviceCatalogRepository): Response
    {
        $serviceCatalog = new ServiceCatalog();
        $form = $this->createForm(ServiceCatalogType::class, $serviceCatalog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceCatalogRepository->save($serviceCatalog, true);

            return $this->redirectToRoute('service_catalog', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_catalog/new.html.twig', [
            'service_catalog' => $serviceCatalog,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'service_catalog_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ServiceCatalog $serviceCatalog, ServiceCatalogRepository $serviceCatalogRepository): Response
    {
        $form = $this->createForm(ServiceCatalogType::class, $serviceCatalog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceCatalogRepository->save($serviceCatalog, true);

            return $this->redirectToRoute('service_catalog', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_catalog/edit.html.twig', [
            'service_catalog' => $serviceCatalog,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'service_catalog_delete', methods: ['GET'])]
    public function delete(Request $request, ServiceCatalog $serviceCatalog, ServiceCatalogRepository $serviceCatalogRepository): Response
    {
        $serviceCatalogRepository->remove($serviceCatalog, true);
        return $this->redirectToRoute('service_catalog', [], Response::HTTP_SEE_OTHER);
    }
}
