<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Form\SearchMediaType;
use App\Repository\MediasRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {


        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class);

        $contact = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $email = (new TemplatedEmail())
            ->from($contact->get('email')->getData())
            ->to('collectifdenface@email.fr')
            ->subject('Contact depuis le site CollectifDenFace')
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'mail'=> $contact->get('email')->getData(),
                'sujet'=> $contact->get('sujet')->getData(),
                'message'=> $contact->get('message')->getData(),
            ])
            ;

            $mailer->send($email);
            $this->addFlash('message', 'Mail de contact envoyé');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('main/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
