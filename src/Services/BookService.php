<?php

namespace GestionBiblio\Services;

use GestionBiblio\Storage\BookStorage;

class BookService {
    private $bookStorage;

    public function __construct(BookStorage $bookStorage) {
        $this->bookStorage = $bookStorage;
    }

    public function createBook($name, $description, $inStock) {
        $id = uniqid();
        $book = new \LibraryManagement\Models\Book($id, $name, $description, $inStock);
        $this->bookStorage->saveBook($book);
        // Log history...
    }

    // Other methods for update, delete, list, show, sort, and search...
}
