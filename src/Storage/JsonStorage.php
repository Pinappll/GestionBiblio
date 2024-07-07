<?php

namespace GestionBiblio\Storage;

use GestionBiblio\Models\Book;

/**
 * Classe JsonStorage
 * 
 * Cette classe est responsable de la gestion du stockage des livres en utilisant un fichier JSON.
 */
class JsonStorage implements BookStorage {
    private $filePath;

    /**
     * Constructeur de la classe JsonStorage
     * 
     * @param string $filePath Le chemin du fichier JSON de stockage des livres.
     */
    public function __construct($filePath) {
        $this->filePath = $filePath;
    }

    /**
     * Charge les livres à partir du fichier JSON de stockage.
     * 
     * @return array Un tableau contenant les objets Book chargés à partir du fichier JSON.
     */
    public function loadBooks() {
        if (!file_exists($this->filePath)) {
            return [];
        }
        $json = file_get_contents($this->filePath);
        $data = json_decode($json, true);
        $books = [];
        foreach ($data as $item) {
            $books[] = new Book($item['id'], $item['name'], $item['description'], $item['inStock']);
        }
        return $books;
    }

    /**
     * Enregistre un livre dans le fichier JSON de stockage.
     * 
     * @param Book $book Le livre à enregistrer.
     * @return void
     */
    public function saveBook(Book $book) {
        $books = $this->loadBooks();
        $books[] = $book;
        $this->saveBooks($books);
    }

    /**
     * Met à jour un livre dans le fichier JSON de stockage.
     * 
     * @param Book $book Le livre à mettre à jour.
     * @return void
     */
    public function updateBook(Book $book) {
        $books = $this->loadBooks();
        foreach ($books as &$b) {
            if ($b->getId() === $book->getId()) {
                $b = $book;
                break;
            }
        }
        $this->saveBooks($books);
    }

    /**
     * Supprime un livre du fichier JSON de stockage.
     * 
     * @param int $id L'identifiant du livre à supprimer.
     * @return void
     */
    public function deleteBook($id) {
        $books = $this->loadBooks();
        foreach ($books as $key => $book) {
            if ($book->getId() === $id) {
                unset($books[$key]);
                break;
            }
        }
        $this->saveBooks($books);
    }

    /**
     * Récupère un livre à partir de son identifiant dans le fichier JSON de stockage.
     * 
     * @param int $id L'identifiant du livre à récupérer.
     * @return Book|null Le livre correspondant à l'identifiant, ou null si aucun livre n'est trouvé.
     */
    public function getBook($id) {
        $books = $this->loadBooks();
        foreach ($books as $book) {
            if ($book->getId() === $id) {
                return $book;
            }
        }
        return null;
    }

    /**
     * Enregistre les livres dans le fichier JSON de stockage.
     * 
     * @param array $books Le tableau contenant les livres à enregistrer.
     * @return void
     */
    private function saveBooks($books) {
        $data = [];
        foreach ($books as $book) {
            $data[] = [
                'id' => $book->getId(),
                'name' => $book->getName(),
                'description' => $book->getDescription(),
                'inStock' => $book->isInStock()
            ];
        }
        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }
}