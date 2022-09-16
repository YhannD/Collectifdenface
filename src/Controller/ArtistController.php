<?php

namespace App\Controller;

use App\Repository\MediasRepository;
use App\Repository\UsersRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtistController extends AbstractController
{
    #[Route('/artists', name: 'app_artists')]
    public function index(UsersRepository $usersRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $data = $usersRepository->findAll();

        $users = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('artist/index.html.twig', compact('users'));
    }

    #[Route('/artists/{alias}', name: 'app_artists_artiste')]
    public function details($alias, UsersRepository $usersRepository, MediasRepository $mediasRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $users = $usersRepository->findOneBy(['alias'=>$alias]);
        $data = $mediasRepository->findBy(['user'=>$users]);

        $medias = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('artist/details.html.twig', compact('users', 'medias'));
    }
}
