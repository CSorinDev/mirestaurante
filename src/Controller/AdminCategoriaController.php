<?php
namespace App\Controller;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/admin/categoria')]
final class AdminCategoriaController extends AbstractController
{
    #[Route(name: 'app_admin_categoria_index', methods: ['GET'])]
    public function index(CategoriaRepository $categoriaRepository): Response
    {
        return $this->render('admin_categoria/index.html.twig', [
            'categorias' => $categoriaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_categoria_new', methods: ['GET', 'POST'])]
    public function new (Request $request, EntityManagerInterface $entityManager): Response
    {
        $categoria = new Categoria();
        $form      = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Categoría creada correctamente.');
            $entityManager->persist($categoria);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_categoria_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_categoria/new.html.twig', [
            'categoria' => $categoria,
            'form'      => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_categoria_show', methods: ['GET'])]
    public function show(Categoria $categoria): Response
    {
        return $this->render('admin_categoria/show.html.twig', [
            'categoria' => $categoria,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_categoria_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categoria $categoria, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Categoría actualizada correctamente.');
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_categoria_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_categoria/edit.html.twig', [
            'categoria' => $categoria,
            'form'      => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_categoria_delete', methods: ['POST'])]
    public function delete(Request $request, Categoria $categoria, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $categoria->getId(), $request->getPayload()->getString('_token'))) {
            if ($categoria->getCartaItems()->count() > 0) {
                $this->addFlash('error', 'No se puede eliminar la categoría porque tiene platos asociados.');
                return $this->redirectToRoute('app_admin_categoria_index', []);
            }
            $this->addFlash('success', 'Categoría eliminada correctamente.');
            $entityManager->remove($categoria);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_categoria_index', []);
    }
}
