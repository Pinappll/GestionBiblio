<?php
namespace GestionBiblio\Commands;

use GestionBiblio\Services\BookService;
use GestionBiblio\Services\HistoryService;
use GestionBiblio\Storage\JsonStorage;

/**
 * La classe Menu représente le menu principal du système de gestion de bibliothèque.
 */
class Menu {
    private $bookService;

    /**
     * Constructeur de la classe Menu.
     * Il crée une instance de BookService en utilisant un JsonStorage et un HistoryService.
     */
    public function __construct() {
        $storage = new JsonStorage('data/books.json');
        $service = new HistoryService();
        
        $this->bookService = new BookService($storage, $service);
    }

    /**
     * Affiche le menu principal et gère les choix de l'utilisateur.
     */
    public function showMenu() {
        while (true) {
            echo "Système de Gestion de Bibliothèque\n";
            echo "1. Ajouter un livre\n";
            echo "2. Mettre à jour un livre\n";
            echo "3. Supprimer un livre\n";
            echo "4. Liste des livres\n";
            echo "5. Afficher un livre\n";
            echo "6. Trier les livres\n";
            echo "7. Rechercher un livre\n";
            echo "8. Quitter\n";

            $choice = readline("Entrez votre choix : ");
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
                    exit("Au revoir !\n");
                default:
                    echo "Choix invalide, veuillez réessayer.\n";
            }
        }
    }
}