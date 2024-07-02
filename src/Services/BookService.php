<?php

namespace GestionBiblio\Services;

use GestionBiblio\Storage\BookStorage;
use GestionBiblio\Models\Book;

class BookService {
    private $bookStorage;
    private $historyService;

    public function __construct(BookStorage $bookStorage, HistoryService $historyService) {
        $this->bookStorage = $bookStorage;
        $this->historyService = $historyService;
    }

    public function createBook($name, $description, $inStock) {
        $id = uniqid();
        $book = new Book($id, $name, $description, $inStock);
        $this->bookStorage->saveBook($book);
        $this->historyService->logAction('CREATE', "Book created: {$id}");
    }

    public function updateBook(Book $book) {
        $this->bookStorage->updateBook($book);
        $this->historyService->logAction('UPDATE', "Book updated: {$book->getId()}");
    }

    public function deleteBook($id) {
        $this->bookStorage->deleteBook($id);
        $this->historyService->logAction('DELETE', "Book deleted: {$id}");
    }

    public function getBook($id) {
        return $this->bookStorage->getBook($id);
    }

    public function loadBooks() {
        return $this->bookStorage->loadBooks();
    }
}