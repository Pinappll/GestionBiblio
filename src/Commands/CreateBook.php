<?php
namespace GestionBiblio\Commands;

use GestionBiblio\Services\BookService;

/**
 * La classe CreateBook représente une commande pour créer un nouveau livre.
 */
class CreateBook {
    private $bookService;

    /**
     * Crée une nouvelle instance de CreateBook.
     *
     * @param BookService $bookService Le service de gestion des livres.
     */
    public function __construct(BookService $bookService) {
        $this->bookService = $bookService;
    }

    /**
     * Exécute la commande de création d'un nouveau livre.
     */
    public function execute() {
        echo "Création d'un nouveau livre...\n";
        $name = readline("Entrez le nom du livre : ");
        $description = readline("Entrez la description du livre : ");
        $inStock = readline("Le livre est-il en stock ? (oui/non) : ");
        $inStock = strtolower($inStock) === 'oui' ? true : false;

        $this->bookService->createBook($name, $description, $inStock);
        echo "Livre créé avec succès.\n";
    }
}