<?php
namespace GestionBiblio\Commands;
use GestionBiblio\Services\BookService;

/**
 * La classe UpdateBook représente une commande pour mettre à jour un livre.
 */
class UpdateBook {
    private $bookService;

    /**
     * Constructeur de la classe UpdateBook.
     *
     * @param BookService $bookService Le service de gestion des livres.
     */
    public function __construct(BookService $bookService) {
        $this->bookService = $bookService;
    }

    /**
     * Exécute la commande de mise à jour d'un livre.
     */
    public function execute() {
        echo "Mise à jour d'un livre...\n";
        $bookId = readline("Entrez l'ID du livre : ");
        $book = $this->bookService->getBook($bookId);

        if ($book === null) {
            echo "Aucun livre trouvé avec l'ID : $bookId\n";
            return;
        }

        echo "Nom actuel : " . $book->getName() . "\n";
        echo "Description actuelle : " . $book->getDescription() . "\n";
        echo "En stock actuellement : " . ($book->isInStock() ? "Oui" : "Non") . "\n";

        $name = readline("Entrez le nouveau nom du livre (appuyez sur Entrée pour ignorer) : ");
        $description = readline("Entrez la nouvelle description du livre (appuyez sur Entrée pour ignorer) : ");
        $inStock = readline("Le livre est-il en stock ? (oui/non/appuyez sur Entrée pour ignorer) : ");

        if (!empty($name)) {
            $book->setName($name);
        }
        if (!empty($description)) {
            $book->setDescription($description);
        }
        if (strtolower($inStock) === 'oui' || strtolower($inStock) === 'non') {
            $book->setInStock(strtolower($inStock) === 'oui');
        }

        $this->bookService->updateBook($book);
        echo "Livre mis à jour avec succès.\n";
    }
}