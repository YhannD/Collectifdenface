<?php

namespace App\Controller;

use App\Entity\Exhibitions;
use App\Repository\ExhibitionsRepository;
use App\Repository\ExhibitionYearRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExhibitionsController extends AbstractController
{
    #[Route('/exhibitions', name: 'app_exhibitions')]
    public function index(ExhibitionsRepository $exhibitionsRepository, ExhibitionYearRepository $exhibitionYearRepository, Request $request): Response
    {
        // On définit le nombre d'éléments par page
        $limit = 3;

        // On récupère le numéro de page
        $page = (int)$request->query->get("page", 1);

        // On récupère les filtres
        $filters = $request->get("years");

        // On récupère les annonces de la page en fonction du filtre
        $exhibitions = $exhibitionsRepository->getPaginatedExhibitions($page, $limit, $filters,);
        dump($exhibitions);

        // On récupère le nombre total d'annonces
        $total = $exhibitionsRepository->getTotalExhibitions($filters);
dump($total);

        // On vérifie si on a une requête Ajax
        if($request->get('ajax')){
            return new JsonResponse([
                'content' => $this->renderView('exhibitions/_content.html.twig', compact('exhibitions', 'total', 'limit', 'page'))
            ]);

        }
$exhibitionsYear = $exhibitionYearRepository->findAll();

        return $this->render('exhibitions/index.html.twig', compact('exhibitions', 'exhibitionsYear', 'total', 'limit', 'page'));
    }

    #[Route('/exhibitions/{name}', name: 'app_exhibitions_details')]
    public function details(Exhibitions $exhibitions): Response
    {
        //On récupère les expos de la section.

        return $this->render('exhibitions/details.html.twig', compact('exhibitions'));
    }
}
