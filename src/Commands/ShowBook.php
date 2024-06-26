<?php
namespace GestionBiblio\Commands;

use GestionBiblio\Services\BookService;

class ShowBook {
    private $bookService;

    public function __construct(BookService $bookService) {
        $this->bookService = $bookService;
    }

    public function execute() {
        echo "Showing book details...\n";
        $bookId = readline("Enter the book ID: ");
        
        $book = $this->bookService->getBook($bookId);
        if ($book === null) {
            echo "No book found with ID: $bookId\n";
            return;
        }

        echo "ID: " . $book->getId() . "\n";
        echo "Name: " . $book->getName() . "\n";
        echo "Description: " . $book->getDescription() . "\n";
        echo "In Stock: " . ($book->isInStock() ? "Yes" : "No") . "\n";
    }
}