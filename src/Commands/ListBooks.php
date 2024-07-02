<?php
namespace GestionBiblio\Commands;

use GestionBiblio\Services\BookService;

class ListBooks {
    private $bookService;

    public function __construct(BookService $bookService) {
        $this->bookService = $bookService;
    }

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