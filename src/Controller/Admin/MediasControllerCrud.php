<?php

namespace App\Controller\Admin;

use App\Entity\Medias;
use App\Entity\MediasImages;
use App\Entity\MediasMusics;
use App\Entity\MediasVideos;
use App\Entity\Users;
use App\Form\MediasType;
use App\Repository\MediasImagesRepository;
use App\Repository\MediasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('admin/medias')]
class MediasControllerCrud extends AbstractController
{
    public function __construct(private SluggerInterface $slugger){}

    #[Route('/', name: 'app_medias_index_admin', methods: ['GET'])]
    public function index(MediasRepository $mediasRepository): Response
    {
        return $this->render('admin/medias/index.html.twig', [
            'medias' => $mediasRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_medias_new_admin', methods: ['GET', 'POST'])]
    public function new(Request $request, MediasRepository $mediasRepository): Response
    {
        $media = new Medias();
        $form = $this->createForm(MediasType::class, $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mediasImages = $form->get('mediasImages')->getData();

            $music = $form->get('mediasMusics')->getData();
            if (!empty($music)){
                $mediasMusics = new MediasMusics();
                $mediasMusics->setName($music);
                $media->addMediasMusic($mediasMusics);
            }

            $video = $form->get('mediasVideos')->getData();
            if(!empty($video)){
                $mediasVideos = new MediasVideos();
                $mediasVideos->setName($video);
                $media->addMediasVideo($mediasVideos);
            }

            foreach ($mediasImages as $mediasImage) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $mediasImage->guessExtension();

                // On copie le fichier dans le dossier uploads
                $mediasImage->move(
                    $this->getParameter('medias_directory'),
                    $fichier
                );
                $mediasImage = new MediasImages();
                $mediasImage->setName($fichier);
                $media->addMediasImage($mediasImage);
                $media->setUser($this->getUser());
            }

            $name = $form->get('name')->getData();
            $media->setSlug($this->slugger->slug(strtolower($name)));

            $mediasRepository->add($media, true);

            return $this->redirectToRoute('app_medias_index_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/medias/new.html.twig', [
            'media' => $media,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_medias_show_admin', methods: ['GET'])]
    public function show(Medias $media): Response
    {
        return $this->render('admin/medias/show.html.twig', [
            'media' => $media,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_medias_edit_admin', methods: ['GET', 'POST'])]
    public function edit(Request $request, Medias $media, MediasRepository $mediasRepository): Response
    {
        $form = $this->createForm(MediasType::class, $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mediasImages = $form->get('mediasImages')->getData();

            $music = $form->get('mediasMusics')->getData();
            if (!empty($music)){
                $mediasMusics = new MediasMusics();
                $mediasMusics->setName($music);
                $media->addMediasMusic($mediasMusics);
            }

            $video = $form->get('mediasVideos')->getData();
            if(!empty($video)){
                $mediasVideos = new MediasVideos();
                $mediasVideos->setName($video);
                $media->addMediasVideo($mediasVideos);
            }

            foreach ($mediasImages as $mediasImage) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $mediasImage->guessExtension();

                // On copie le fichier dans le dossier uploads
                $mediasImage->move(
                    $this->getParameter('medias_directory'),
                    $fichier
                );
                $mediasImage = new MediasImages();
                $mediasImage->setName($fichier);
                $media->addMediasImage($mediasImage);
            }

            $name = $form->get('name')->getData();
            $media->setSlug($this->slugger->slug(strtolower($name)));

            $mediasRepository->add($media, true);

            return $this->redirectToRoute('app_medias_index_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/medias/edit.html.twig', [
            'media' => $media,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_medias_delete_admin', methods: ['POST'])]
    public function delete(Request $request, Medias $media, MediasRepository $mediasRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$media->getId(), $request->request->get('_token'))) {
            $mediasRepository->remove($media, true);
        }

        return $this->redirectToRoute('app_medias_index_admin', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/delete/image/{id}', name: 'app_medias_delete_image_admin', methods: ['DELETE'])]
    public function deleteImages(MediasImagesRepository $mediasImagesRepository, MediasImages $mediasImages, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(),true);

        if($this->isCsrfTokenValid('delete'.$mediasImages->getId(), $data['_token'])){
            $nom = $mediasImages->getName();
            unlink($this->getParameter('medias_directory').'/'.$nom);

            $mediasImagesRepository->remove($mediasImages, true);
            return new JsonResponse(['success'=> 1]);
        }else{
            return new JsonResponse(['error'=> 'Token Invalide'],400);
        }
    }
}
