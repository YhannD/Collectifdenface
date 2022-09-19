<?php

namespace App\Controller;

use App\Entity\Exhibitions;
use App\Repository\ExhibitionsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExhibitionsController extends AbstractController
{
    #[Route('/exhibitions', name: 'app_exhibitions')]
    public function index(ExhibitionsRepository $exhibitionsRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $exhibitions = $paginator->paginate(
            $exhibitionsRepository->findAll(),
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('exhibitions/index.html.twig', [
            'exhibitions' => $exhibitions,
        ]);
    }

    #[Route('/exhibitions/{name}', name: 'app_exhibitions_details')]
    public function details(Exhibitions $exhibitions): Response
    {
        //On récupère les expos de la section.

        return $this->render('exhibitions/details.html.twig', compact('exhibitions'));
    }
}
