<?php

namespace App\Controller\Users;

use App\Entity\Medias;
use App\Entity\MediasImages;
use App\Entity\MediasMusics;
use App\Entity\MediasVideos;
use App\Form\MediasType;
use App\Form\MediasTypeUsers;
use App\Repository\MediasImagesRepository;
use App\Repository\MediasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('users/medias')]
class MediasControllerCrud extends AbstractController
{
    #[Route('/', name: 'app_medias_index', methods: ['GET'])]
    public function index(MediasRepository $mediasRepository): Response
    {
        $user = $this->getUser();
        return $this->render('users/medias/index.html.twig', [
            'medias' => $mediasRepository->findBy(['user'=>$user]),
        ]);
    }
    #[Route('/new', name: 'app_medias_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MediasRepository $mediasRepository): Response
    {
        $media = new Medias();
        $form = $this->createForm(MediasTypeUsers::class, $media);
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

            $media->setUser($this->getUser());
            $mediasRepository->add($media, true);

            return $this->redirectToRoute('app_medias_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('users/medias/new.html.twig', [
            'media' => $media,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_medias_show', methods: ['GET'])]
    public function show(Medias $media): Response
    {
        return $this->render('users/medias/show.html.twig', [
            'media' => $media,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_medias_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Medias $media, MediasRepository $mediasRepository): Response
    {
        $form = $this->createForm(MediasTypeUsers::class, $media);
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
            $media->setUser($this->getUser());
            $mediasRepository->add($media, true);

            return $this->redirectToRoute('app_medias_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('users/medias/edit.html.twig', [
            'media' => $media,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_medias_delete', methods: ['POST'])]
    public function delete(Request $request, Medias $media, MediasRepository $mediasRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$media->getId(), $request->request->get('_token'))) {
            $mediasRepository->remove($media, true);
        }

        return $this->redirectToRoute('app_medias_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/delete/image/{id}', name: 'app_medias_delete_image', methods: ['DELETE'])]
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
