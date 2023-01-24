<?php

namespace App\Controller;

use App\Entity\GenreBook;
use App\Form\GenreBookType;
use App\Repository\GenreBookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/genre/book')]
class GenreBookController extends AbstractController
{
    #[Route('/', name: 'app_genre_book_index', methods: ['GET'])]
    public function index(GenreBookRepository $genreBookRepository): Response
    {
        return $this->render('genre_book/index.html.twig', [
            'genre_books' => $genreBookRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_genre_book_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GenreBookRepository $genreBookRepository): Response
    {
        $genreBook = new GenreBook();
        $form = $this->createForm(GenreBookType::class, $genreBook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $genreBookRepository->save($genreBook, true);

            return $this->redirectToRoute('app_genre_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('genre_book/new.html.twig', [
            'genre_book' => $genreBook,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_genre_book_show', methods: ['GET'])]
    public function show(GenreBook $genreBook): Response
    {
        return $this->render('genre_book/show.html.twig', [
            'genre_book' => $genreBook,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_genre_book_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, GenreBook $genreBook, GenreBookRepository $genreBookRepository): Response
    {
        $form = $this->createForm(GenreBookType::class, $genreBook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $genreBookRepository->save($genreBook, true);

            return $this->redirectToRoute('app_genre_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('genre_book/edit.html.twig', [
            'genre_book' => $genreBook,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_genre_book_delete', methods: ['POST'])]
    public function delete(Request $request, GenreBook $genreBook, GenreBookRepository $genreBookRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$genreBook->getId(), $request->request->get('_token'))) {
            $genreBookRepository->remove($genreBook, true);
        }

        return $this->redirectToRoute('app_genre_book_index', [], Response::HTTP_SEE_OTHER);
    }
}
