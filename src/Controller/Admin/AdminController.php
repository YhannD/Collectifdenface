<?php

namespace App\Controller\Admin;

use App\Entity\Medias;
use App\Entity\Users;
use App\Form\EditUserType;
use App\Repository\MediasRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/utilisateurs', name: 'app_admin_utilisateurs')]
    public function usersList(UsersRepository $users): Response
    {
        return $this->render('admin/users.html.twig', [
            'users' => $users->findAll(),
        ]);
    }

    #[Route('/admin/utilisateurs/modifier/{id}', name: 'app_admin_modifier_utilisateurs')]
    public function editUser(UsersRepository $usersRepository, Users $users, Request $request): Response
    {
        $form = $this->createForm(EditUserType::class, $users);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usersRepository->add($users, true);

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('app_admin_utilisateurs');
        }

        return $this->render('admin/edituser.html.twig', [
            'userForm' => $form->createView(),
            'users'=>$users
        ]);
    }

    #[Route('/admin/{id}', name: 'app_admin_supprimer_utilisateurs', methods: ['POST'])]
    public function delete(Request $request, Users $users, UsersRepository $usersRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$users->getId(), $request->request->get('_token'))) {
            $usersRepository->remove($users, true);
        }

        return $this->redirectToRoute('app_admin_utilisateurs', [], Response::HTTP_SEE_OTHER);
    }

}
