<?php

namespace App\Controller\Admin;

use App\Entity\Exhibitions;
use App\Entity\ExhibitionsImages;
use App\Form\ExhibitionsType;
use App\Repository\ExhibitionsImagesRepository;
use App\Repository\ExhibitionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('admin/exhibitions')]
class ExhibitionsControllerCrud extends AbstractController
{

    public function __construct(private SluggerInterface $slugger){}

    #[Route('/', name: 'app_exhibitions_index', methods: ['GET'])]
    public function index(ExhibitionsRepository $exhibitionsRepository): Response
    {
        return $this->render('admin/exhibitions/index.html.twig', [
            'exhibitions' => $exhibitionsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_exhibitions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ExhibitionsRepository $exhibitionsRepository): Response
    {
        $exhibition = new Exhibitions();
        $form = $this->createForm(ExhibitionsType::class, $exhibition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $exhibitionsImages = $form->get('exhibitionsImages')->getData();
            foreach ($exhibitionsImages as $exhibitionsImage) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $exhibitionsImage->guessExtension();

                // On copie le fichier dans le dossier uploads
                $exhibitionsImage->move(
                    $this->getParameter('exhibitions_directory'),
                    $fichier
                );
                $exhibitionsImage = new ExhibitionsImages();
                $exhibitionsImage->setName($fichier);
                $exhibition->addExhibitionsImage($exhibitionsImage);
            }

            $name = $form->get('name')->getData();
            $exhibition->setSlug($this->slugger->slug(strtolower($name)));

            $exhibitionsRepository->add($exhibition, true);

            return $this->redirectToRoute('app_exhibitions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/exhibitions/new.html.twig', [
            'exhibition' => $exhibition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exhibitions_show', methods: ['GET'])]
    public function show(Exhibitions $exhibition): Response
    {
        return $this->render('admin/exhibitions/show.html.twig', [
            'exhibition' => $exhibition,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_exhibitions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Exhibitions $exhibition, ExhibitionsRepository $exhibitionsRepository): Response
    {
        $form = $this->createForm(ExhibitionsType::class, $exhibition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {$exhibitionsImages = $form->get('exhibitionsImages')->getData();
            foreach ($exhibitionsImages as $exhibitionsImage) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $exhibitionsImage->guessExtension();

                // On copie le fichier dans le dossier uploads
                $exhibitionsImage->move(
                    $this->getParameter('exhibitions_directory'),
                    $fichier
                );
                $exhibitionsImage = new ExhibitionsImages();
                $exhibitionsImage->setName($fichier);
                $exhibition->addExhibitionsImage($exhibitionsImage);
            }

            $name = $form->get('name')->getData();
            $exhibition->setSlug($this->slugger->slug(strtolower($name)));

            $exhibitionsRepository->add($exhibition, true);

            return $this->redirectToRoute('app_exhibitions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/exhibitions/edit.html.twig', [
            'exhibition' => $exhibition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exhibitions_delete', methods: ['POST'])]
    public function delete(Request $request, Exhibitions $exhibition, ExhibitionsRepository $exhibitionsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exhibition->getId(), $request->request->get('_token'))) {
            $exhibitionsRepository->remove($exhibition, true);
        }

        return $this->redirectToRoute('app_exhibitions_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/delete/image/{id}', name: 'app_exhibitions_delete_image', methods: ['DELETE'])]
    public function deleteImages(ExhibitionsImagesRepository $exhibitionsImagesRepository, ExhibitionsImages $exhibitionsImages, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(),true);

        if($this->isCsrfTokenValid('delete'.$exhibitionsImages->getId(), $data['_token'])){
            $nom = $exhibitionsImages->getName();
            unlink($this->getParameter('exhibitions_directory').'/'.$nom);

            $exhibitionsImagesRepository->remove($exhibitionsImages, true);
            return new JsonResponse(['success'=> 1]);
        }else{
            return new JsonResponse(['error'=> 'Token Invalide'],400);
        }
    }
}
