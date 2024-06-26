<?php

namespace GestionBiblio\Services;

use GestionBiblio\Storage\BookStorage;
use GestionBiblio\Models\Book;

class BookService {
    private $bookStorage;

    public function __construct(BookStorage $bookStorage) {
        $this->bookStorage = $bookStorage;
    }

    public function createBook($name, $description, $inStock) {
        $id = uniqid();
        $book = new Book($id, $name, $description, $inStock);
        $this->bookStorage->saveBook($book);
        // Log history...
    }

    public function updateBook(Book $book) {
        $this->bookStorage->updateBook($book);
        // Log history...
    }

    public function deleteBook($id) {
        $this->bookStorage->deleteBook($id);
        // Log history...
    }

    public function getBook($id) {
        return $this->bookStorage->getBook($id);
    }

    public function loadBooks() {
        return $this->bookStorage->loadBooks();
    }
}