<?php
namespace GestionBiblio\Commands;

use GestionBiblio\Services\BookService;

/**
 * La classe ShowBook représente une commande pour afficher les détails d'un livre.
 */
class ShowBook {
    private $bookService;

    /**
     * Constructeur de la classe ShowBook.
     *
     * @param BookService $bookService Le service de gestion des livres.
     */
    public function __construct(BookService $bookService) {
        $this->bookService = $bookService;
    }

    /**
     * Exécute la commande pour afficher les détails d'un livre.
     */
    public function execute() {
        echo "Affichage des détails du livre...\n";
        $bookId = readline("Entrez l'ID du livre : ");
        
        $book = $this->bookService->getBook($bookId);
        if ($book === null) {
            echo "Aucun livre trouvé avec l'ID : $bookId\n";
            return;
        }

        echo "ID : " . $book->getId() . "\n";
        echo "Nom : " . $book->getName() . "\n";
        echo "Description : " . $book->getDescription() . "\n";
        echo "En stock : " . ($book->isInStock() ? "Oui" : "Non") . "\n";
    }
}