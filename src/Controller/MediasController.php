<?php

namespace App\Controller;

use App\Entity\Medias;
use App\Repository\CategoriesRepository;
use App\Repository\MediasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('medias')]
class MediasController extends AbstractController
{
    #[Route('/', name: 'app_medias_categories')]
    public function index( MediasRepository $mediasRepository, CategoriesRepository $categoriesRepository, Request $request/*, CacheInterface $cache*/): Response
    {

//        // On définit le nombre d'éléments par page
        $limit = 3;
//
//        // On récupère le numéro de page
//        $page = (int)$request->query->get("page", 1);

        //On va chercher le numéro de page dans l'url
        $page = $request->query->getInt('page', 1);
//
//        // On récupère les filtres
        $filters = $request->get("categories");
//
        $mots = $request->query->get("mots");
//
//        // On récupère les annonces de la page en fonction du filtre
        $medias = $mediasRepository->getPaginatedMedias($page, $limit, $filters, $mots );
dump($medias);

//        // On récupère le nombre total d'annonces
        $total = $mediasRepository->getTotalMedias($mots,$filters, null);
        dump($total,$mots, $filters);
        $categories = $categoriesRepository->findAll();

        //On va chercher la liste des produits de la catégorie
//        $medias = $mediasRepository->findProductsPaginated(1, $filters, 19);


//            $data = $medias['data'];

//        dump($medias,$data);

//        // On vérifie si on a une requête Ajax
        if($request->get('ajax')){
            return new JsonResponse([
                'content' => $this->renderView(
                    'medias/_content.html.twig',
                    [
                        'medias' => $medias,
                         'total' => $total,
                         'limit' => $limit,
                        'page' => $page,
                        'categories' => $categories,
//                        'data' => $data,
                    ]
                )]);
        }

//        return $this->render('medias/index.html.twig', compact('medias', /*'total', 'limit',*/ 'page', 'categories', $data));
        return $this->render(
            'medias/index.html.twig',
            [
                'medias' => $medias,
                 'total' => $total,
                 'limit' => $limit,
                'page' => $page,
                'categories' => $categories,
//                'data' => $data,
            ]
        );

    }

    #[Route('/images', name: 'app_medias_images')]
    public function indexImages(MediasRepository $mediasRepository, CategoriesRepository $categoriesRepository, Request $request/*, CacheInterface $cache*/): JsonResponse|Response
    {
        // On définit le nombre d'éléments par page
        $limit = 10;

        // On récupère le numéro de page
        $page = (int)$request->query->get("page", 1);

        // On récupère les filtres
        $filters = $request->get("categories");

        $mots = $request->query->get("mots");

        // On récupère les annonces de la page en fonction du filtre
        $medias = $mediasRepository->getPaginatedMedias($page, $limit, $filters, 1, $mots);
dd($medias);
        // On récupère le nombre total d'annonces
        $total = $mediasRepository->getTotalMedias($mots,$filters ,1);
dump($total);

        $categories = $categoriesRepository->findAll();

        // On vérifie si on a une requête Ajax
        if($request->get('ajax')){
            return new JsonResponse([
                'content' => $this->renderView('medias/_content.html.twig', [
                    'total' => $total,
                    'limit' => $limit,
                    'page' => $page,
                    'categories' => $categories,
                    'medias' => $medias,
                ])]);
        }

        /*// On va chercher toutes les catégories
        $categories = $cache->get('categories_list', function(ItemInterface $item) use($catRepo){
            $item->expiresAfter(3600);

            return $catRepo->findAll();
        });*/



        return $this->render('medias/index.html.twig', [
            'total' => $total,
            'limit' => $limit,
            'page' => $page,
            'categories' => $categories,
            'medias' => $medias,
        ]);
    }

    #[Route('/musics', name: 'app_medias_musics')]
    public function indexMusics(MediasRepository $mediasRepository, CategoriesRepository $categoriesRepository, Request $request/*, CacheInterface $cache*/): JsonResponse|Response
    {
        // On définit le nombre d'éléments par page
        $limit = 10;

        // On récupère le numéro de page
        $page = (int)$request->query->get("page", 1);

        // On récupère les filtres
        $filters = $request->get("categories");

        $mots = $request->query->get("mots");

        // On récupère les annonces de la page en fonction du filtre
        $medias = $mediasRepository->getPaginatedMedias($page, $limit, $filters, 2, $mots);
//dd($medias);
        // On récupère le nombre total d'annonces
        $total = $mediasRepository->getTotalMedias($filters, 2);
//dd($total);
        // On vérifie si on a une requête Ajax
        if($request->get('ajax')){
            return new JsonResponse([
                'content' => $this->renderView('medias/_content.html.twig', compact('medias', 'total', 'limit', 'page'))
            ]);
        }

        /*// On va chercher toutes les catégories
        $categories = $cache->get('categories_list', function(ItemInterface $item) use($catRepo){
            $item->expiresAfter(3600);

            return $catRepo->findAll();
        });*/

        $categories = $categoriesRepository->findAll();

        return $this->render('medias/index.html.twig', compact('medias', 'total', 'limit', 'page', 'categories'));
    }
    #[Route('/videos', name: 'app_medias_videos')]
    public function indexVideos(MediasRepository $mediasRepository, CategoriesRepository $categoriesRepository, Request $request/*, CacheInterface $cache*/): JsonResponse|Response
    {
        // On définit le nombre d'éléments par page
        $limit = 10;

        // On récupère le numéro de page
        $page = (int)$request->query->get("page", 1);

        // On récupère les filtres
        $filters = $request->get("categories");

        $mots = $request->query->get("mots");

        // On récupère les annonces de la page en fonction du filtre
        $medias = $mediasRepository->getPaginatedMedias($page, $limit, $filters,3, $mots);
//dd($medias);
        // On récupère le nombre total d'annonces
        $total = $mediasRepository->getTotalMedias($filters, 3);
//dd($total);
        // On vérifie si on a une requête Ajax
        if($request->get('ajax')){
            return new JsonResponse([
                'content' => $this->renderView('medias/_content.html.twig', compact('medias', 'total', 'limit', 'page'))
            ]);
        }

        /*// On va chercher toutes les catégories
        $categories = $cache->get('categories_list', function(ItemInterface $item) use($catRepo){
            $item->expiresAfter(3600);

            return $catRepo->findAll();
        });*/

        $categories = $categoriesRepository->findAll();

        return $this->render('medias/index.html.twig', compact('medias', 'total', 'limit', 'page', 'categories'));
    }
    #[Route('/editions', name: 'app_medias_editions')]
    public function indexEditions(MediasRepository $mediasRepository, CategoriesRepository $categoriesRepository, Request $request/*, CacheInterface $cache*/): JsonResponse|Response
    {
        // On définit le nombre d'éléments par page
        $limit = 10;

        // On récupère le numéro de page
        $page = (int)$request->query->get("page", 1);

        // On récupère les filtres
        $filters = $request->get("categories");

        $mots = $request->query->get("mots");

        // On récupère les annonces de la page en fonction du filtre
        $medias = $mediasRepository->getPaginatedMedias($page, $limit, $filters,4, $mots);
//dd($medias);
        // On récupère le nombre total d'annonces
        $total = $mediasRepository->getTotalMedias($filters, 4);
//dd($total);
        // On vérifie si on a une requête Ajax
        if($request->get('ajax')){
            return new JsonResponse([
                'content' => $this->renderView('medias/_content.html.twig', compact('medias', 'total', 'limit', 'page'))
            ]);
        }

        /*// On va chercher toutes les catégories
        $categories = $cache->get('categories_list', function(ItemInterface $item) use($catRepo){
            $item->expiresAfter(3600);

            return $catRepo->findAll();
        });*/

        $categories = $categoriesRepository->findAll();

        return $this->render('medias/index.html.twig', compact('medias', 'total', 'limit', 'page', 'categories'));
    }
    #[Route('/{slug}', name: 'app_medias_details')]
    public function details(Medias $medias): Response
    {
        //On récupère les expos de la section.

        return $this->render('medias/details.html.twig', compact('medias'));
    }
}
