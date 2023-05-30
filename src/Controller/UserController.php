<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\ClientRepository;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(User::ROLE_ADMIN, statusCode: 423), Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users'         => $userRepository->findAll(),
            'currentUserId' => $this->getUser()->getId(),
        ]);
    }

    #[Route('/new', name: 'user_create', methods: ['GET', 'POST'])]
    public function create(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $userPasswordHasher
    ): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $weekends = $request->request->get('weekends');;
            $weekends = array_filter(explode(',', $weekends), fn($v) => $v !== '');
            $user->setWeekends($weekends);

            $userRepository->save($user, true);

            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user'       => $user,
            'form'       => $form,
            'refererUrl' => $request->headers->get('referer'),
        ]);
    }

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(
        Request $request,
        User $user,
        ClientRepository $clientRepository,
        ServiceRepository $serviceRepository
    ): Response
    {
        $serviceDate = $request->query->get('serviceDate');

        return $this->render('user/show.html.twig', [
            'user'        => $user,
            'clients'     => $clientRepository->findBy(['user' => $user]),
            'services'    => $serviceRepository->findByUserAndServiceDate($user->getId(), $serviceDate),
            'refererUrl'  => $request->headers->get('referer'),
            'serviceDate' => $serviceDate,
        ]);
    }

    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        User $user,
        UserRepository $userRepository,
        UserPasswordHasherInterface $userPasswordHasher
    ): Response
    {
        $oldPassword = $user->getPassword();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('password')->getData() === '') {
                $user->setPassword($oldPassword);
            } else {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
            }

            $weekends = $request->request->get('weekends');;
            $weekends = array_filter(explode(',', $weekends), fn($v) => $v !== '');
            $user->setWeekends($weekends);

            $userRepository->save($user, true);

            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user'       => $user,
            'form'       => $form,
            'refererUrl' => $request->headers->get('referer'),
        ]);
    }

    #[Route('/{id}/delete', name: 'user_delete', methods: ['GET'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        $userRepository->remove($user, true);
        return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
    }
}
