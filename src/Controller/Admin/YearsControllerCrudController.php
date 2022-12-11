<?php

namespace App\Controller\Admin;

use App\Entity\ExhibitionsYears;
use App\Form\ExhibitionsYearsType;
use App\Repository\ExhibitionYearRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/years')]
class YearsControllerCrudController extends AbstractController
{

    #[Route('/', name: 'app_years_index', methods: ['GET'])]
    public function index(ExhibitionYearRepository $exhibitionYearRepository): Response
    {
        return $this->render('admin/years/index.html.twig', [
            'exhibitions_years' => $exhibitionYearRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_years_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ExhibitionYearRepository $exhibitionYearRepository): Response
    {
        $exhibitionsYear = new ExhibitionsYears();
        $form = $this->createForm(ExhibitionsYearsType::class, $exhibitionsYear);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $exhibitionYearRepository->save($exhibitionsYear, true);

            return $this->redirectToRoute('app_years_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/years/new.html.twig', [
            'exhibitions_year' => $exhibitionsYear,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_years_show', methods: ['GET'])]
    public function show(ExhibitionsYears $exhibitionsYear): Response
    {
        return $this->render('admin/years/show.html.twig', [
            'exhibitions_year' => $exhibitionsYear,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_years_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ExhibitionsYears $exhibitionsYear, ExhibitionYearRepository $exhibitionYearRepository): Response
    {
        $form = $this->createForm(ExhibitionsYearsType::class, $exhibitionsYear);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $exhibitionYearRepository->save($exhibitionsYear, true);

            return $this->redirectToRoute('app_years_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/years/edit.html.twig', [
            'exhibitions_year' => $exhibitionsYear,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_years_delete', methods: ['POST'])]
    public function delete(Request $request, ExhibitionsYears $exhibitionsYear, ExhibitionYearRepository $exhibitionYearRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exhibitionsYear->getId(), $request->request->get('_token'))) {
            $exhibitionYearRepository->remove($exhibitionsYear, true);
        }

        return $this->redirectToRoute('app_years_index', [], Response::HTTP_SEE_OTHER);
    }
}
