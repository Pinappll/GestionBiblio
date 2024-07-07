<?php

namespace GestionBiblio\Commands;

use GestionBiblio\Services\BookService;
use GestionBiblio\Utils\BinarySearch;
use GestionBiblio\Utils\QuickSort;

class SearchBook {
    private $bookService;

    public function __construct(BookService $bookService) {
        $this->bookService = $bookService;
    }

    public function execute() {
        echo "Searching for a book...\n";
        $column = readline("Entrez colum to search (id/name/description/inStock) : ");
        $searchTerm = readline("Enter value to search: ");

        $validColumns = ['id', 'name', 'description', 'inStock'];
        if (!in_array($column, $validColumns)) {
            echo "Invalid column. Please choose 'id', 'name', 'description' or 'inStock'.\n";
            return;
        }

        $books = $this->bookService->loadBooks();
        if (empty($books)) {
            echo "No books available for search.\n";
            return;
        }

        // Tri rapide des livres par la colonne choisie
        $books = $this->sortBooks($books, $column);

        // Recherche binaire du livre
        $foundBooks = $this->binarySearch($books, $column, $searchTerm);

        if (empty($foundBooks)) {
            echo "Aucun livre trouvé correspondant à votre recherche.\n";
            return;
        }

        foreach ($foundBooks as $book) {
            echo "ID : " . $book->getId() . "\n";
            echo "Name : " . $book->getName() . "\n";
            echo "Description : " . $book->getDescription() . "\n";
            echo "In Stock : " . ($book->isInStock() ? "Yes" : "No") . "\n";
            echo "-----------------------\n";
        }
    }

    private function sortBooks($books, $column) {
        $sortFunction = function($a, $b) use ($column) {
            switch ($column) {
                case 'id':
                    return strcmp($a->getId(), $b->getId());
                case 'name':
                    return strcmp($a->getName(), $b->getName());
                case 'description':
                    return strcmp($a->getDescription(), $b->getDescription());
                case 'inStock':
                    return $a->isInStock() - $b->isInStock();
                default:
                    return 0;
            }
        };

        return QuickSort::sort($books, $sortFunction);
    }

    private function binarySearch($books, $column, $searchTerm) {
        return BinarySearch::search($books, $column, $searchTerm);
    }
}
?>
