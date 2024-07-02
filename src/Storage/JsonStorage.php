<?php

namespace GestionBiblio\Storage;

use GestionBiblio\Models\Book;

class JsonStorage implements BookStorage {
    private $filePath;

    public function __construct($filePath) {
        $this->filePath = $filePath;
    }

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

    public function saveBook(Book $book) {
        $books = $this->loadBooks();
        $books[] = $book;
        $this->saveBooks($books);
    }

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

    public function getBook($id) {
        $books = $this->loadBooks();
        foreach ($books as $book) {
            if ($book->getId() === $id) {
                return $book;
            }
        }
        return null;
    }

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