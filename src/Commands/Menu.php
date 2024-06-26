<?php

namespace GestionBiblio\Commands;

use GestionBiblio\Services\BookService;
use GestionBiblio\Storage\JsonStorage;

class Menu {
    private $bookService;

    public function __construct() {
        $storage = new JsonStorage('data/books.json');
        $this->bookService = new BookService($storage);
    }

    public function showMenu() {
        while (true) {
            echo "Library Management System\n";
            echo "1. Add Book\n";
            echo "2. Update Book\n";
            echo "3. Delete Book\n";
            echo "4. List Books\n";
            echo "5. Show Book\n";
            echo "6. Sort Books\n";
            echo "7. Search Book\n";
            echo "8. Exit\n";

            $choice = readline("Enter your choice: ");
            switch ($choice) {
                case 1:
                    $name = readline("Enter book name: ");
                    $description = readline("Enter book description: ");
                    $inStock = readline("Is the book in stock (yes/no)? ") === 'yes';
                    $this->bookService->createBook($name, $description, $inStock);
                    break;
                case 2:
                    $id = readline("Enter book ID to update: ");
                    $name = readline("Enter new book name: ");
                    $description = readline("Enter new book description: ");
                    $inStock = readline("Is the book in stock (yes/no)? ") === 'yes';
                    $this->bookService->updateBook($id, $name, $description, $inStock);
                    break;
                case 3:
                    $id = readline("Enter book ID to delete: ");
                    $this->bookService->deleteBook($id);
                    break;
                case 4:
                    $this->bookService->listBooks();
                    break;
                case 5:
                    $id = readline("Enter book ID to show: ");
                    $this->bookService->showBook($id);
                    break;
                case 6:
                    $key = readline("Enter the field to sort by (name, description, inStock): ");
                    $order = readline("Enter the order (asc/desc): ");
                    $this->bookService->sortBooks($key, $order);
                    break;
                case 7:
                    $key = readline("Enter the field to search by (name, description, inStock, id): ");
                    $value = readline("Enter the value to search: ");
                    $this->bookService->searchBook($key, $value);
                    break;
                case 8:
                    exit("Goodbye!\n");
                default:
                    echo "Invalid choice, please try again.\n";
            }
        }
    }
}
