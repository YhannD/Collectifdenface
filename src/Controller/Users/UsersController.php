<?php

namespace App\Controller\Users;

use App\Form\EditProfileType;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('profile')]
class UsersController extends AbstractController
{
    public function __construct(private SluggerInterface $slugger){}

    #[Route('/', name: 'app_profile')]
    public function index(): Response
    {
        return $this->render('users/index.html.twig');
    }

    #[Route('/profile/edit', name: 'app_profile_edit')]
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
            $alias = $form->get('alias')->getData();
            $user->setSlug($this->slugger->slug(strtolower($alias)));

            $usersRepository->add($user, true);

            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('users/editprofile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
