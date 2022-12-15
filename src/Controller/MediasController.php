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
    public function index(MediasRepository $mediasRepository, CategoriesRepository $categoriesRepository, Request $request/*, CacheInterface $cache*/): JsonResponse|Response
    {

        // This variable defines the number of elements per page
        $limit = 14;

        // This variable holds the current page number
        $page = (int)$request->query->get("page", 1);

        // This variable holds any filters that have been applied
        $filters = $request->get("categories");

        // This variable holds any search terms that have been applied
        $mots = $request->query->get("mots");

        // This line retrieves the media items for the current page based on the filters
        $medias = $mediasRepository->getPaginatedMedias($page, $limit, $filters, $mots, null);

        // This line retrieves the total number of media items
        $total = $mediasRepository->getTotalMedias($mots, $filters, null);

        // This line retrieves all categories
        $categories = $categoriesRepository->findAll();

        // This line checks if the request is an AJAX request
        if ($request->get('ajax')) {
            // If it is, it returns a JSON response with the rendered view
            return new JsonResponse([
                'content' => $this->renderView('medias/_content.html.twig', compact('medias', 'total', 'limit', 'page'))
            ]);
        }
        // Render the "medias/index.html.twig" template, passing in the
        // following variables to be used in the template
        return $this->render(
            'medias/index.html.twig',
            [
                'medias' => $medias,
                'total' => $total,
                'limit' => $limit,
                'page' => $page,
                'categories' => $categories
            ]
        );

    }

    #[Route('/images', name: 'app_medias_images')]
    public function indexImages(MediasRepository $mediasRepository, CategoriesRepository $categoriesRepository, Request $request/*, CacheInterface $cache*/): JsonResponse|Response
    {
        // This variable defines the number of elements per page
        $limit = 14;

        // This variable holds the current page number
        $page = (int)$request->query->get("page", 1);

        // This variable holds any filters that have been applied
        $filters = $request->get("categories");

        // This variable holds any search terms that have been applied
        $mots = $request->query->get("mots");

        // This line retrieves the media items for the current page based on the filters
        $medias = $mediasRepository->getPaginatedMedias($page, $limit, $filters, $mots, 1);

        // This line retrieves the total number of media items
        $total = $mediasRepository->getTotalMedias($mots, $filters, 1);

        // This line retrieves all categories
        $categories = $categoriesRepository->findAll();

        // This line checks if the request is an AJAX request
        if ($request->get('ajax')) {
            // If it is, it returns a JSON response with the rendered view
            return new JsonResponse([
                'content' => $this->renderView('medias/_content.html.twig', compact('medias', 'total', 'limit', 'page'))
            ]);
        }
        // Render the "medias/index.html.twig" template, passing in the
        // following variables to be used in the template
        return $this->render(
            'medias/index.html.twig', compact('medias', 'total', 'limit', 'page', 'categories'));
    }

    #[Route('/musics', name: 'app_medias_musics')]
    public function indexMusics(MediasRepository $mediasRepository, CategoriesRepository $categoriesRepository, Request $request/*, CacheInterface $cache*/): JsonResponse|Response
    {
        $limit = 14;

        // This variable holds the current page number
        $page = (int)$request->query->get("page", 1);

        // This variable holds any filters that have been applied
        $filters = $request->get("categories");

        // This variable holds any search terms that have been applied
        $mots = $request->query->get("mots");

        // This line retrieves the media items for the current page based on the filters
        $medias = $mediasRepository->getPaginatedMedias($page, $limit, $filters, $mots, 2);

        // This line retrieves the total number of media items
        $total = $mediasRepository->getTotalMedias($mots, $filters, 2);

        // This line retrieves all categories
        $categories = $categoriesRepository->findAll();

        // This line checks if the request is an AJAX request
        if ($request->get('ajax')) {
            // If it is, it returns a JSON response with the rendered view
            return new JsonResponse([
                'content' => $this->renderView('medias/_content.html.twig', compact('medias', 'total', 'limit', 'page'))
            ]);
        }
        // Render the "medias/index.html.twig" template, passing in the
        // following variables to be used in the template
        return $this->render(
            'medias/index.html.twig', compact('medias', 'total', 'limit', 'page', 'categories'));
    }

    #[Route('/videos', name: 'app_medias_videos')]
    public function indexVideos(MediasRepository $mediasRepository, CategoriesRepository $categoriesRepository, Request $request/*, CacheInterface $cache*/): JsonResponse|Response
    {
        // This variable defines the number of elements per page
        $limit = 14;

        // This variable holds the current page number
        $page = (int)$request->query->get("page", 1);

        // This variable holds any filters that have been applied
        $filters = $request->get("categories");

        // This variable holds any search terms that have been applied
        $mots = $request->query->get("mots");

        // This line retrieves the media items for the current page based on the filters
        $medias = $mediasRepository->getPaginatedMedias($page, $limit, $filters, $mots, 3);

        // This line retrieves the total number of media items
        $total = $mediasRepository->getTotalMedias($mots, $filters, 3);

        // This line retrieves all categories
        $categories = $categoriesRepository->findAll();
        dump($medias, $categories, $total);
        // This line checks if the request is an AJAX request
        if ($request->get('ajax')) {
            // If it is, it returns a JSON response with the rendered view
            return new JsonResponse([
                'content' => $this->renderView('medias/_content.html.twig', compact('medias', 'total', 'limit', 'page'))
            ]);
        }
        // Render the "medias/index.html.twig" template, passing in the
        // following variables to be used in the template
        return $this->render(
            'medias/index.html.twig', compact('medias', 'total', 'limit', 'page', 'categories'));
    }

    #[Route('/editions', name: 'app_medias_editions')]
    public function indexEditions(MediasRepository $mediasRepository, CategoriesRepository $categoriesRepository, Request $request/*, CacheInterface $cache*/): JsonResponse|Response
    {
        // This variable defines the number of elements per page
        $limit = 14;

        // This variable holds the current page number
        $page = (int)$request->query->get("page", 1);

        // This variable holds any filters that have been applied
        $filters = $request->get("categories");

        // This variable holds any search terms that have been applied
        $mots = $request->query->get("mots");

        // This line retrieves the media items for the current page based on the filters
        $medias = $mediasRepository->getPaginatedMedias($page, $limit, $filters, $mots, 4);

        // This line retrieves the total number of media items
        $total = $mediasRepository->getTotalMedias($mots, $filters, 4);

        // This line retrieves all categories
        $categories = $categoriesRepository->findAll();

        // This line checks if the request is an AJAX request
        if ($request->get('ajax')) {
            // If it is, it returns a JSON response with the rendered view
            return new JsonResponse([
                'content' => $this->renderView('medias/_content.html.twig', compact('medias', 'total', 'limit', 'page'))
            ]);
        }
        // Render the "medias/index.html.twig" template, passing in the
        // following variables to be used in the template
        return $this->render(
            'medias/index.html.twig', compact('medias', 'total', 'limit', 'page', 'categories'));
    }


    #[Route('/{slug}', name: 'app_medias_details')]
    public function details(Medias $medias): Response
    {
        //On récupère les expos de la section.

        return $this->render('medias/details.html.twig', compact('medias'));
    }
}
