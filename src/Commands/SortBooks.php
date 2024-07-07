<?php
namespace GestionBiblio\Commands;

use GestionBiblio\Services\BookService;
use GestionBiblio\Utils\MergeSort;
use GestionBiblio\Utils\QuickSort;

/**
 * La classe SortBooks représente une commande pour trier les livres.
 */
class SortBooks {
    private $bookService;

    /**
     * Constructeur de la classe SortBooks.
     *
     * @param BookService $bookService Le service de gestion des livres.
     */
    public function __construct(BookService $bookService) {
        $this->bookService = $bookService;
    }

    /**
     * Exécute la commande de tri des livres.
     */
    public function execute() {
        echo "Tri des livres...\n";
        $sortMethod = readline("Entrez la méthode de tri (fusion/rapide) : ");

        $books = $this->bookService->loadBooks();
        if (empty($books)) {
            echo "Aucun livre disponible à trier.\n";
            return;
        }

        switch (strtolower($sortMethod)) {
            case 'fusion':
                $sortedBooks = MergeSort::sort($books, function($a, $b) {
                    return strcmp($a->getName(), $b->getName());
                });
                break;
            case 'rapide':
                $sortedBooks = QuickSort::sort($books, function($a, $b) {
                    return strcmp($a->getName(), $b->getName());
                });
                break;
            default:
                echo "Méthode de tri invalide. Veuillez choisir 'fusion' ou 'rapide'.\n";
                return;
        }

        foreach ($sortedBooks as $book) {
            echo "ID : " . $book->getId() . "\n";
            echo "Nom : " . $book->getName() . "\n";
            echo "Description : " . $book->getDescription() . "\n";
            echo "En stock : " . ($book->isInStock() ? "Oui" : "Non") . "\n";
            echo "-----------------------\n";
        }
    }
}