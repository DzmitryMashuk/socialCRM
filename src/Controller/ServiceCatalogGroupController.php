<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\ServiceCatalogGroup;
use App\Form\ServiceCatalogGroupType;
use App\Repository\ServiceCatalogGroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN', statusCode: 423), Route('/service/catalog/group')]
class ServiceCatalogGroupController extends AbstractController
{
    #[Route('/', name: 'service_catalog_group', methods: ['GET'])]
    public function index(ServiceCatalogGroupRepository $serviceCatalogGroupRepository): Response
    {
        return $this->render('service_catalog_group/index.html.twig', [
            'serviceCatalogGroups' => $serviceCatalogGroupRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'service_catalog_group_create', methods: ['GET', 'POST'])]
    public function create(Request $request, ServiceCatalogGroupRepository $serviceCatalogGroupRepository): Response
    {
        $serviceCatalogGroup = new ServiceCatalogGroup();
        $form = $this->createForm(ServiceCatalogGroupType::class, $serviceCatalogGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceCatalogGroupRepository->save($serviceCatalogGroup, true);

            return $this->redirectToRoute('service_catalog_group', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('service_catalog_group/new.html.twig', [
            'serviceCatalogGroup' => $serviceCatalogGroup,
            'form'                => $form,
            'refererUrl'          => $request->headers->get('referer'),
        ]);
    }

    #[Route('/{id}/edit', name: 'service_catalog_group_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        ServiceCatalogGroup $serviceCatalogGroup,
        ServiceCatalogGroupRepository $serviceCatalogGroupRepository
    ): Response
    {
        $form = $this->createForm(ServiceCatalogGroupType::class, $serviceCatalogGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceCatalogGroupRepository->save($serviceCatalogGroup, true);

            return $this->redirectToRoute('service_catalog_group', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('service_catalog_group/edit.html.twig', [
            'serviceCatalogGroup' => $serviceCatalogGroup,
            'form'                => $form,
            'refererUrl'          => $request->headers->get('referer'),
        ]);
    }

    #[Route('/{id}', name: 'service_catalog_group_delete', methods: ['GET'])]
    public function delete(
        ServiceCatalogGroup $serviceCatalogGroup,
        ServiceCatalogGroupRepository $serviceCatalogGroupRepository
    ): Response
    {
        $serviceCatalogGroupRepository->remove($serviceCatalogGroup, true);
        return $this->redirectToRoute('service_catalog_group', [], Response::HTTP_SEE_OTHER);
    }
}
