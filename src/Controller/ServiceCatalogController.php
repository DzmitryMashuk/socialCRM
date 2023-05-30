<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ServiceCatalog;
use App\Form\ServiceCatalogType;
use App\Repository\ServiceCatalogGroupRepository;
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
            'serviceCatalogs' => $serviceCatalogRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'service_catalog_create', methods: ['GET', 'POST'])]
    public function create(
        Request $request,
        ServiceCatalogRepository $serviceCatalogRepository,
        ServiceCatalogGroupRepository $serviceCatalogGroupRepository
    ): Response
    {
        $serviceCatalog = new ServiceCatalog();
        $form = $this->createForm(ServiceCatalogType::class, $serviceCatalog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceCatalogGroupId = $request->request->get('serviceCatalogGroupId');
            $serviceCatalogGroup = $serviceCatalogGroupRepository->find($serviceCatalogGroupId);
            $serviceCatalog->setServiceCatalogGroup($serviceCatalogGroup);

            $serviceCatalogRepository->save($serviceCatalog, true);

            return $this->redirectToRoute('service_catalog', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('service_catalog/new.html.twig', [
            'serviceCatalog'       => $serviceCatalog,
            'serviceCatalogGroups' => $serviceCatalogGroupRepository->findAll(),
            'form'                 => $form,
            'refererUrl'           => $request->headers->get('referer'),
        ]);
    }

    #[Route('/{id}/edit', name: 'service_catalog_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        ServiceCatalog $serviceCatalog,
        ServiceCatalogRepository $serviceCatalogRepository,
        ServiceCatalogGroupRepository $serviceCatalogGroupRepository
    ): Response
    {
        $form = $this->createForm(ServiceCatalogType::class, $serviceCatalog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceCatalogGroupId = $request->request->get('serviceCatalogGroupId');
            $serviceCatalogGroup = $serviceCatalogGroupRepository->find($serviceCatalogGroupId);
            $serviceCatalog->setServiceCatalogGroup($serviceCatalogGroup);

            $serviceCatalogRepository->save($serviceCatalog, true);

            return $this->redirectToRoute('service_catalog', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('service_catalog/edit.html.twig', [
            'serviceCatalog'       => $serviceCatalog,
            'serviceCatalogGroups' => $serviceCatalogGroupRepository->findAll(),
            'form'                 => $form,
            'refererUrl'           => $request->headers->get('referer'),
        ]);
    }

    #[Route('/{id}/delete', name: 'service_catalog_delete', methods: ['GET'])]
    public function delete(
        Request $request,
        ServiceCatalog $serviceCatalog,
        ServiceCatalogRepository $serviceCatalogRepository
    ): Response
    {
        $serviceCatalogRepository->remove($serviceCatalog, true);
        return $this->redirectToRoute('service_catalog', [], Response::HTTP_SEE_OTHER);
    }
}
