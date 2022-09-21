<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Form\EditUserType;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminController extends AbstractController
{
    public function __construct(private SluggerInterface $slugger){}

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
            $image = $form->get('image')->getData();
            if ($image) {
                $data = md5(uniqid()) . 'Controller' . $image->guessExtension();
                $image->move(
                    $this->getParameter('profiles_directory'),
                    $data,
                );
                $users->setImage($data);
            }

            $alias = $form->get('alias')->getData();
            $users->setSlug($this->slugger->slug(strtolower($alias)));

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
