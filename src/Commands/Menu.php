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
                    $createBookCommand = new CreateBook($this->bookService);
                    $createBookCommand->execute();
                    break;
                case 2:
                    $updateBookCommand = new UpdateBook($this->bookService);
                    $updateBookCommand->execute();
                    break;
                case 3:
                    $deleteBookCommand = new DeleteBook($this->bookService);
                    $deleteBookCommand->execute();
                    break;
                case 4:
                    $listBooksCommand = new ListBooks($this->bookService);
                    $listBooksCommand->execute();
                    break;
                case 5:
                    $showBookCommand = new ShowBook($this->bookService);
                    $showBookCommand->execute();
                    break;
                case 6:
                    $sortBooksCommand = new SortBooks($this->bookService);
                    $sortBooksCommand->execute();
                    break;
                case 7:
                    $searchBookCommand = new SearchBook($this->bookService);
                    $searchBookCommand->execute();
                    break;
                case 8:
                    exit("Goodbye!\n");
                default:
                    echo "Invalid choice, please try again.\n";
            }
        }
    }
}