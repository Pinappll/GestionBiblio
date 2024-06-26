<?php
namespace GestionBiblio\Commands;

use GestionBiblio\Services\BookService;
use GestionBiblio\Utils\MergeSort;
use GestionBiblio\Utils\QuickSort;

class SortBooks {
    private $bookService;

    public function __construct(BookService $bookService) {
        $this->bookService = $bookService;
    }

    public function execute() {
        echo "Sorting books...\n";
        $sortMethod = readline("Enter sort method (merge/quick): ");

        $books = $this->bookService->loadBooks();
        if (empty($books)) {
            echo "No books available to sort.\n";
            return;
        }

        switch (strtolower($sortMethod)) {
            case 'merge':
                $sortedBooks = MergeSort::sort($books, function($a, $b) {
                    return strcmp($a->getName(), $b->getName());
                });
                break;
            case 'quick':
                $sortedBooks = QuickSort::sort($books, function($a, $b) {
                    return strcmp($a->getName(), $b->getName());
                });
                break;
            default:
                echo "Invalid sort method. Please choose 'merge' or 'quick'.\n";
                return;
        }

        foreach ($sortedBooks as $book) {
            echo "ID: " . $book->getId() . "\n";
            echo "Name: " . $book->getName() . "\n";
            echo "Description: " . $book->getDescription() . "\n";
            echo "In Stock: " . ($book->isInStock() ? "Yes" : "No") . "\n";
            echo "-----------------------\n";
        }
    }
}