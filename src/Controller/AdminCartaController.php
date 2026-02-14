<?php
namespace App\Controller;

use App\Entity\Carta;
use App\Form\CartaType;
use App\Repository\CartaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function new (Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $carta = new Carta();
        $form  = $this->createForm(CartaType::class, $carta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('foto_archivo')->getData();

            if ($imageFile) {
                $newFilename = $this->uploadImage($imageFile, $slugger);
                $carta->setImagen($newFilename);
            }

            $entityManager->persist($carta);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_carta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_carta/new.html.twig', [
            'carta' => $carta,
            'form'  => $form,
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
    public function edit(Request $request, Carta $carta, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(CartaType::class, $carta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('foto_archivo')->getData();

            if ($imageFile) {
                $this->deleteOldImage($carta->getImagen());
                
                $newFilename = $this->uploadImage($imageFile, $slugger);
                $carta->setImagen($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_admin_carta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_carta/edit.html.twig', [
            'carta' => $carta,
            'form'  => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_carta_delete', methods: ['POST'])]
    public function delete(Request $request, Carta $carta, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $carta->getId(), $request->getPayload()->getString('_token'))) {
            $this->deleteOldImage($carta->getImagen());

            $entityManager->remove($carta);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_carta_index', [], Response::HTTP_SEE_OTHER);
    }

    private function uploadImage($imageFile, SluggerInterface $slugger): string
    {
        $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename     = $slugger->slug($originalFilename);
        $newFilename      = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

        try {
            $imageFile->move(
                $this->getParameter('imagenes_productos_directory'),
                $newFilename
            );
        } catch (FileException $e) {
            // Error al subir
        }

        return $newFilename;
    }

    private function deleteOldImage(?string $filename): void
    {
        if ($filename) {
            $path = $this->getParameter('imagenes_productos_directory') . '/' . $filename;
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }
}
