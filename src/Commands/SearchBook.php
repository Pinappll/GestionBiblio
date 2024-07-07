<?php

namespace GestionBiblio\Commands;

use GestionBiblio\Services\BookService;
use GestionBiblio\Utils\BinarySearch;
use GestionBiblio\Utils\QuickSort;

/**
 * Représente une commande de recherche de livre.
 */
class SearchBook {
    private $bookService;

    /**
     * Crée une nouvelle instance de la classe SearchBook.
     *
     * @param BookService $bookService Le service de gestion des livres.
     */
    public function __construct(BookService $bookService) {
        $this->bookService = $bookService;
    }

    /**
     * Exécute la commande de recherche de livre.
     */
    public function execute() {
        echo "Recherche d'un livre...\n";
        $column = readline("Entrez la colonne à rechercher (id/name/description/inStock) : ");
        $searchTerm = readline("Entrez la valeur à rechercher : ");

        $validColumns = ['id', 'name', 'description', 'inStock'];
        if (!in_array($column, $validColumns)) {
            echo "Colonne invalide. Veuillez choisir 'id', 'name', 'description' ou 'inStock'.\n";
            return;
        }

        $books = $this->bookService->loadBooks();
        if (empty($books)) {
            echo "Aucun livre disponible pour la recherche.\n";
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
            echo "Nom : " . $book->getName() . "\n";
            echo "Description : " . $book->getDescription() . "\n";
            echo "En Stock : " . ($book->isInStock() ? "Oui" : "Non") . "\n";
            echo "-----------------------\n";
        }
    }

    /**
     * Trie les livres selon la colonne spécifiée.
     *
     * @param array $books Les livres à trier.
     * @param string $column La colonne de tri.
     * @return array Les livres triés.
     */
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

    /**
     * Effectue une recherche binaire dans les livres selon la colonne et la valeur spécifiées.
     *
     * @param array $books Les livres dans lesquels effectuer la recherche.
     * @param string $column La colonne de recherche.
     * @param string $searchTerm La valeur à rechercher.
     * @return array Les livres trouvés correspondant à la recherche.
     */
    private function binarySearch($books, $column, $searchTerm) {
        return BinarySearch::search($books, $column, $searchTerm);
    }
}
?>
