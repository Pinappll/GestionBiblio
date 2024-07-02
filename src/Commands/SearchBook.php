<?php
namespace GestionBiblio\Commands;

use GestionBiblio\Services\BookService;

class SearchBook {
    private $bookService;

    public function __construct(BookService $bookService) {
        $this->bookService = $bookService;
    }

    public function execute() {
        echo "Searching for a book...\n";
        $searchTerm = readline("Enter book name or description to search: ");
        
        $books = $this->bookService->loadBooks();
        $foundBooks = array_filter($books, function($book) use ($searchTerm) {
            return stripos($book->getName(), $searchTerm) !== false || stripos($book->getDescription(), $searchTerm) !== false;
        });

        if (empty($foundBooks)) {
            echo "No books found matching your search.\n";
            return;
        }

        foreach ($foundBooks as $book) {
            echo "ID: " . $book->getId() . "\n";
            echo "Name: " . $book->getName() . "\n";
            echo "Description: " . $book->getDescription() . "\n";
            echo "In Stock: " . ($book->isInStock() ? "Yes" : "No") . "\n";
            echo "-----------------------\n";
        }
    }
}