<?php

namespace GestionBiblio\Commands;

use GestionBiblio\Services\BookService;
use GestionBiblio\Utils\MergeSort;
use GestionBiblio\Utils\QuickSort;

/**
 * Classe SortBooks
 * 
 * Cette classe représente une commande de tri des livres.
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
        $input = readline("Entrez la méthode de tri (merge/quick) [colonne] [ordre] (asc/desc) : ");
        $parts = explode(' ', $input);
        $method = $parts[0] ?? null;
        $column = $parts[1] ?? null;
        $order = $parts[2] ?? 'asc';

        if (!$method || !$column || !in_array($order, ['asc', 'desc'])) {
            echo "Entrée invalide. Veuillez entrer la méthode de tri, la colonne et l'ordre (asc/desc).\n";
            return;
        }

        $ascending = $order === 'asc';

        $books = $this->bookService->loadBooks();
        if (empty($books)) {
            echo "Aucun livre disponible pour le tri.\n";
            return;
        }

        $sortedBooks = $this->sortBooks($books, strtolower($method), $column, $ascending);

        if ($sortedBooks === null) {
            return;
        }

        foreach ($sortedBooks as $book) {
            echo "ID : " . $book->getId() . "\n";
            echo "Nom : " . $book->getName() . "\n";
            echo "Description : " . $book->getDescription() . "\n";
            echo "En Stock : " . ($book->isInStock() ? "Oui" : "Non") . "\n";
            echo "-----------------------\n";
        }
    }

    /**
     * Trie les livres selon la méthode, la colonne et l'ordre spécifiés.
     * 
     * @param array $books Les livres à trier.
     * @param string $method La méthode de tri (merge/quick).
     * @param string $column La colonne de tri (name/description/inStock).
     * @param bool $ascending L'ordre de tri (true pour ascendant, false pour descendant).
     * 
     * @return array|null Les livres triés ou null en cas d'erreur.
     */
    private function sortBooks($books, $method, $column, $ascending) {
        $validColumns = ['name', 'description', 'inStock'];
        if (!in_array($column, $validColumns)) {
            echo "Colonne invalide. Veuillez choisir 'name', 'description' ou 'inStock'.\n";
            return null;
        }

        $sortFunction = function($a, $b) use ($column, $ascending) {
            switch ($column) {
                case 'name':
                    $comparison = strcmp($a->getName(), $b->getName());
                    break;
                case 'description':
                    $comparison = strcmp($a->getDescription(), $b->getDescription());
                    break;
                case 'inStock':
                    $comparison = $a->isInStock() - $b->isInStock();
                    break;
                default:
                    $comparison = 0;
            }
            return $ascending ? $comparison : -$comparison;
        };

        switch ($method) {
            case 'merge':
                echo "Tri fusion...\n";
                return MergeSort::sort($books, $sortFunction);
            case 'quick':
                echo "Tri rapide...\n";
                return QuickSort::sort($books, $sortFunction);
            default:
                echo "Méthode de tri invalide. Veuillez choisir 'merge' ou 'quick'.\n";
                return null;
        }
    }
}
?>
