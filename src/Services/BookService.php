<?php

namespace GestionBiblio\Services;

use GestionBiblio\Storage\BookStorage;
use GestionBiblio\Models\Book;

/**
 * Classe BookService
 * 
 * Service de gestion des livres de la bibliothèque.
 */
class BookService {
    private $bookStorage;
    private $historyService;

    /**
     * Constructeur de la classe BookService.
     * 
     * @param BookStorage $bookStorage Le service de stockage des livres.
     * @param HistoryService $historyService Le service de gestion de l'historique.
     */
    public function __construct(BookStorage $bookStorage, HistoryService $historyService) {
        $this->bookStorage = $bookStorage;
        $this->historyService = $historyService;
    }

    /**
     * Crée un nouveau livre.
     * 
     * @param string $name Le nom du livre.
     * @param string $description La description du livre.
     * @param int $inStock Le nombre d'exemplaires en stock.
     * @return void
     */
    public function createBook($name, $description, $inStock) {
        $id = uniqid();
        $book = new Book($id, $name, $description, $inStock);
        $this->bookStorage->saveBook($book);
        $this->historyService->logAction('CREATE', "Livre créé : {$id}");
    }

    /**
     * Met à jour un livre existant.
     * 
     * @param Book $book Le livre à mettre à jour.
     * @return void
     */
    public function updateBook(Book $book) {
        $this->bookStorage->updateBook($book);
        $this->historyService->logAction('UPDATE', "Livre mis à jour : {$book->getId()}");
    }

    /**
     * Supprime un livre.
     * 
     * @param string $id L'identifiant du livre à supprimer.
     * @return void
     */
    public function deleteBook($id) {
        $this->bookStorage->deleteBook($id);
        $this->historyService->logAction('DELETE', "Livre supprimé : {$id}");
    }

    /**
     * Récupère un livre par son identifiant.
     * 
     * @param string $id L'identifiant du livre à récupérer.
     * @return Book|null Le livre correspondant à l'identifiant, ou null si aucun livre n'est trouvé.
     */
    public function getBook($id) {
        return $this->bookStorage->getBook($id);
    }

    /**
     * Charge tous les livres.
     * 
     * @return array La liste des livres.
     */
    public function loadBooks() {
        return $this->bookStorage->loadBooks();
    }
}