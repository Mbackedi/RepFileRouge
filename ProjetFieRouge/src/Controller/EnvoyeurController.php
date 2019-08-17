<?php

namespace App\Controller;

use App\Entity\Envoyeur;
use App\Form\EnvoyeurType;
use App\Repository\EnvoyeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/envoyeur")
 */
class EnvoyeurController extends AbstractController
{
    /**
     * @Route("/", name="envoyeur_index", methods={"GET"})
     */
    public function index(EnvoyeurRepository $envoyeurRepository): Response
    {
        return $this->render('envoyeur/index.html.twig', [
            'envoyeurs' => $envoyeurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="envoyeur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $envoyeur = new Envoyeur();
        $form = $this->createForm(EnvoyeurType::class, $envoyeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($envoyeur);
            $entityManager->flush();

            return $this->redirectToRoute('envoyeur_index');
        }

        return $this->render('envoyeur/new.html.twig', [
            'envoyeur' => $envoyeur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="envoyeur_show", methods={"GET"})
     */
    public function show(Envoyeur $envoyeur): Response
    {
        return $this->render('envoyeur/show.html.twig', [
            'envoyeur' => $envoyeur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="envoyeur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Envoyeur $envoyeur): Response
    {
        $form = $this->createForm(EnvoyeurType::class, $envoyeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('envoyeur_index');
        }

        return $this->render('envoyeur/edit.html.twig', [
            'envoyeur' => $envoyeur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="envoyeur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Envoyeur $envoyeur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$envoyeur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($envoyeur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('envoyeur_index');
    }
}
