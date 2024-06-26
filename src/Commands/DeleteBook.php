<?php
namespace GestionBiblio\Commands;

use GestionBiblio\Services\BookService;

class CreateBook {
    private $bookService;

    public function __construct(BookService $bookService) {
        $this->bookService = $bookService;
    }

    public function execute() {
        echo "Creating a new book...\n";
        $name = readline("Enter book name: ");
        $description = readline("Enter book description: ");
        $inStock = readline("Is the book in stock? (yes/no): ");
        $inStock = strtolower($inStock) === 'yes' ? true : false;

        $this->bookService->createBook($name, $description, $inStock);
        echo "Book created successfully.\n";
    }
}