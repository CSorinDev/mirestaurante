<?php

namespace App\Controller;

use App\Entity\Carta;
use App\Form\CartaType;
use App\Repository\CartaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/carta')]
final class AdminCartaController extends AbstractController
{
    #[Route(name: 'app_admin_carta_index', methods: ['GET'])]
    public function index(CartaRepository $cartaRepository): Response
    {
        return $this->render('admin_carta/index.html.twig', [
            'cartas' => $cartaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_carta_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $carta = new Carta();
        $form = $this->createForm(CartaType::class, $carta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($carta);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_carta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_carta/new.html.twig', [
            'carta' => $carta,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_carta_show', methods: ['GET'])]
    public function show(Carta $carta): Response
    {
        return $this->render('admin_carta/show.html.twig', [
            'carta' => $carta,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_carta_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Carta $carta, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CartaType::class, $carta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_carta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_carta/edit.html.twig', [
            'carta' => $carta,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_carta_delete', methods: ['POST'])]
    public function delete(Request $request, Carta $carta, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carta->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($carta);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_carta_index', [], Response::HTTP_SEE_OTHER);
    }
}
