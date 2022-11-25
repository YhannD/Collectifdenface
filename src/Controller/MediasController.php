<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Form\SearchForm;
use App\Entity\Medias;
use App\Form\SearchMediaType;
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
//    #[Route('/medias', name: 'app_medias')]
//    public function index(): Response
//    {
//        return $this->render('medias/index.html.twig', [
//            'controller_name' => 'MediasController',
//        ]);
//    }
    #[Route('/', name: 'app_medias_categories')]
//    public function indexCategories(MediasRepository $mediasRepository, Request $request, SearchData $data): Response
//    {
//        $data->page = (int)$request->get('page',1);
//        $form = $this->createForm(SearchForm::class, $data);
//        $form->handleRequest($request);
//        $medias = $mediasRepository->selectByCategoryAndSection($data);
//        return $this->render('medias/index.html.twig', [
//            'medias' => $medias,
//            'form' =>$form->createView()
//        ]);
//    }
    public function index(MediasRepository $mediasRepository, CategoriesRepository $categoriesRepository, Request $request/*, CacheInterface $cache*/): JsonResponse|Response
    {

        // On définit le nombre d'éléments par page
        $limit = 10;

        // On récupère le numéro de page
        $page = (int)$request->query->get("page", 1);

        // On récupère les filtres
        $filters = $request->get("categories");
        // On récupère les annonces de la page en fonction du filtre
        $medias = $mediasRepository->getPaginatedMedias($page, $limit, $filters);
//dd($medias);
        // On récupère le nombre total d'annonces
        $total = $mediasRepository->getTotalMedias($filters);
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

    #[Route('/images', name: 'app_medias_images')]
//    public function indexImages(MediasRepository $mediasRepository, Request $request, SearchData $data): Response
//    {
//        $data->page = $request->get('page',1);
//        $form = $this->createForm(SearchForm::class, $data);
//        $form->handleRequest($request);
//        $medias = $mediasRepository->selectByCategoryAndSection($data, 1);
//        return $this->render('medias/index.html.twig', [
//            'medias' => $medias,
//            'form' =>$form->createView()
//        ]);
//    }
    public function indexImages(MediasRepository $mediasRepository, CategoriesRepository $categoriesRepository, Request $request/*, CacheInterface $cache*/): JsonResponse|Response
    {
        // On définit le nombre d'éléments par page
        $limit = 10;

        // On récupère le numéro de page
        $page = (int)$request->query->get("page", 1);

        // On récupère les filtres
        $filters = $request->get("categories");
        // On récupère les annonces de la page en fonction du filtre
        $medias = $mediasRepository->getPaginatedMedias($page, $limit, $filters, 1);
//dd($medias);
        // On récupère le nombre total d'annonces
        $total = $mediasRepository->getTotalMedias($filters, 1);
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

    #[Route('/musics', name: 'app_medias_musics')]
    public function indexMusics(MediasRepository $mediasRepository, CategoriesRepository $categoriesRepository, Request $request/*, CacheInterface $cache*/): JsonResponse|Response
    {
        // On définit le nombre d'éléments par page
        $limit = 10;

        // On récupère le numéro de page
        $page = (int)$request->query->get("page", 1);

        // On récupère les filtres
        $filters = $request->get("categories");
        // On récupère les annonces de la page en fonction du filtre
        $medias = $mediasRepository->getPaginatedMedias($page, $limit, $filters, 2);
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
        // On récupère les annonces de la page en fonction du filtre
        $medias = $mediasRepository->getPaginatedMedias($page, $limit, $filters,3);
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
        // On récupère les annonces de la page en fonction du filtre
        $medias = $mediasRepository->getPaginatedMedias($page, $limit, $filters,4);
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
