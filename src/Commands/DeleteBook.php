<?php
namespace GestionBiblio\Commands;

use GestionBiblio\Services\BookService;

class DeleteBook {
    private $bookService;

    public function __construct(BookService $bookService) {
        $this->bookService = $bookService;
    }

    public function execute() {
        echo "Deleting a book...\n";
        $id = readline("Enter book ID to delete: ");

        if ($this->bookService->deleteBook($id)) {
            echo "Book deleted successfully.\n";
        } else {
            echo "Book not found.\n";
        }
    }
}