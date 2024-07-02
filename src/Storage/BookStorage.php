<?php

namespace GestionBiblio\Storage;

use GestionBiblio\Models\Book;

interface BookStorage {
    public function loadBooks();
    public function saveBook(Book $book);
    public function updateBook(Book $book);
    public function deleteBook($id);
    public function getBook($id);
}