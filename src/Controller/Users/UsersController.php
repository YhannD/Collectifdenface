<?php

namespace App\Controller\Users;

use App\Entity\MediasImages;
use App\Entity\Users;
use App\Form\EditProfileType;
use App\Repository\MediasImagesRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route('/users', name: 'app_users')]
    public function index(): Response
    {
        return $this->render('users/index.html.twig');
    }

    #[Route('/users/profile/edit', name: 'app_users_profile_edit')]
    public function editProfile(UsersRepository $usersRepository, Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $image = $form->get('image')->getData();
            if ($image) {
                $data = md5(uniqid()) . 'Controller' . $image->guessExtension();
                $image->move(
                    $this->getParameter('profiles_directory'),
                    $data,
                );
                $user->setImage($data);
            }
            $usersRepository->add($user, true);

            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('app_users');
        }

        return $this->render('users/editprofile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
