<?php
namespace GestionBiblio\Commands;
use GestionBiblio\Services\BookService;

class UpdateBook {
    private $bookService;

    public function __construct(BookService $bookService) {
        $this->bookService = $bookService;
    }

    public function execute() {
        echo "Updating a book...\n";
        $bookId = readline("Enter the book ID: ");
        $book = $this->bookService->getBook($bookId);

        if ($book === null) {
            echo "No book found with ID: $bookId\n";
            return;
        }

        echo "Current Name: " . $book->getName() . "\n";
        echo "Current Description: " . $book->getDescription() . "\n";
        echo "Current In Stock: " . ($book->isInStock() ? "Yes" : "No") . "\n";

        $name = readline("Enter new book name (press enter to skip): ");
        $description = readline("Enter new book description (press enter to skip): ");
        $inStock = readline("Is the book in stock? (yes/no/press enter to skip): ");

        if (!empty($name)) {
            $book->setName($name);
        }
        if (!empty($description)) {
            $book->setDescription($description);
        }
        if (strtolower($inStock) === 'yes' || strtolower($inStock) === 'no') {
            $book->setInStock(strtolower($inStock) === 'yes');
        }

        $this->bookService->updateBook($book);
        echo "Book updated successfully.\n";
    }
}