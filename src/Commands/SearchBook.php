<?php
namespace GestionBiblio\Commands;

use GestionBiblio\Services\BookService;

/**
 * Représente la commande de recherche de livre.
 */
class SearchBook {
    private $bookService;

    /**
     * Constructeur de la classe SearchBook.
     *
     * @param BookService $bookService Le service de gestion des livres.
     */
    public function __construct(BookService $bookService) {
        $this->bookService = $bookService;
    }

    /**
     * Exécute la commande de recherche de livre.
     */
    public function execute() {
        echo "Recherche d'un livre...\n";
        $searchTerm = readline("Entrez le nom ou la description du livre à rechercher : ");
        
        $books = $this->bookService->loadBooks();
        $foundBooks = array_filter($books, function($book) use ($searchTerm) {
            return stripos($book->getName(), $searchTerm) !== false || stripos($book->getDescription(), $searchTerm) !== false;
        });

        if (empty($foundBooks)) {
            echo "Aucun livre trouvé correspondant à votre recherche.\n";
            return;
        }

        foreach ($foundBooks as $book) {
            echo "ID : " . $book->getId() . "\n";
            echo "Nom : " . $book->getName() . "\n";
            echo "Description : " . $book->getDescription() . "\n";
            echo "En stock : " . ($book->isInStock() ? "Oui" : "Non") . "\n";
            echo "-----------------------\n";
        }
    }
}