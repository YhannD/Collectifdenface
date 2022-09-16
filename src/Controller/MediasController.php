<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Form\SearchForm;
use App\Entity\Medias;
use App\Repository\MediasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MediasController extends AbstractController
{
    #[Route('/medias', name: 'app_medias')]
    public function index(): Response
    {
        return $this->render('medias/index.html.twig', [
            'controller_name' => 'MediasController',
        ]);
    }
    #[Route('/medias/categories', name: 'app_medias_categories')]
    public function indexCategories(MediasRepository $mediasRepository, Request $request): Response
    {
        $data = new SearchData();
        $data->page = $request->get('page',1);
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        $medias = $mediasRepository->findSearch($data);
        return $this->render('medias/index.html.twig', [
            'medias' => $medias,
            'form' =>$form->createView()
        ]);
    }
    #[Route('/medias/images', name: 'app_medias_images')]
    public function indexImages(MediasRepository $mediasRepository, Request $request): Response
    {
        $data = new SearchData();
        $data->page = $request->get('page',1);
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        $medias = $mediasRepository->findImagesType($data);
        return $this->render('medias/index.html.twig', [
            'medias' => $medias,
            'form' =>$form->createView()
        ]);
    }
    #[Route('/medias/musics', name: 'app_medias_musics')]
    public function indexMusics(MediasRepository $mediasRepository, Request $request): Response
    {
        $data = new SearchData();
        $data->page = $request->get('page',1);
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        $medias = $mediasRepository->findMusicsType($data);
        return $this->render('medias/index.html.twig', [
            'medias' => $medias,
            'form' =>$form->createView()
        ]);
    }
    #[Route('/medias/videos', name: 'app_medias_videos')]
    public function indexVideos(MediasRepository $mediasRepository, Request $request): Response
    {

        $data = new SearchData();
        $data->page = $request->get('page',1);
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        $medias = $mediasRepository->findVideosType($data);
        return $this->render('medias/index.html.twig', [
            'medias' => $medias,
            'form' =>$form->createView()
        ]);
    }
    #[Route('/medias/editions', name: 'app_medias_editions')]
    public function indexEditions(MediasRepository $mediasRepository, Request $request): Response
    {

        $data = new SearchData();
        $data->page = $request->get('page',1);
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        $medias = $mediasRepository->findEditionType($data);
        return $this->render('medias/index.html.twig', [
            'medias' => $medias,
            'form' =>$form->createView()
        ]);
    }
    #[Route('/medias/{id}', name: 'app_medias_details')]
    public function details(Medias $medias): Response
    {
        //On récupère les expos de la section.

        return $this->render('medias/details.html.twig', compact('medias'));
    }
}
