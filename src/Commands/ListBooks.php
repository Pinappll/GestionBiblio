<?php
namespace GestionBiblio\Commands;

use GestionBiblio\Services\BookService;

/**
 * La classe ListBooks représente une commande pour lister tous les livres.
 */
class ListBooks {
    private $bookService;

    /**
     * Constructeur de la classe ListBooks.
     *
     * @param BookService $bookService Le service de gestion des livres.
     */
    public function __construct(BookService $bookService) {
        $this->bookService = $bookService;
    }

    /**
     * Exécute la commande pour lister tous les livres.
     */
    public function execute() {
        echo "Listing all books...\n";
        $books = $this->bookService->loadBooks();

        if (empty($books)) {
            echo "No books found.\n";
            return;
        }

        foreach ($books as $book) {
            echo "ID: " . $book->getId() . "\n";
            echo "Name: " . $book->getName() . "\n";
            echo "Description: " . $book->getDescription() . "\n";
            echo "In Stock: " . ($book->isInStock() ? "Yes" : "No") . "\n";
            echo "-----------------------\n";
        }
    }
}