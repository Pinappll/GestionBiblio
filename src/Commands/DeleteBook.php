<?php
namespace GestionBiblio\Commands;

use GestionBiblio\Services\BookService;

/**
 * La classe DeleteBook représente une commande pour supprimer un livre.
 */
class DeleteBook {
    private $bookService;

    /**
     * Constructeur de la classe DeleteBook.
     *
     * @param BookService $bookService Le service de gestion des livres.
     */
    public function __construct(BookService $bookService) {
        $this->bookService = $bookService;
    }

    /**
     * Exécute la commande de suppression d'un livre.
     */
    public function execute() {
        echo "Suppression d'un livre...\n";
        $id = readline("Entrez l'ID du livre à supprimer : ");

        if ($this->bookService->deleteBook($id)) {
            echo "Livre supprimé avec succès.\n";
        } else {
            echo "Livre introuvable.\n";
        }
    }
}