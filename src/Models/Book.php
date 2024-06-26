<?php

namespace GestionBiblio\Models;

class Book {
    private $id;
    private $name;
    private $description;
    private $inStock;

    public function __construct($id, $name, $description, $inStock) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->inStock = $inStock;
    }

    // Getters and setters...

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function isInStock() {
        return $this->inStock;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setInStock($inStock) {
        $this->inStock = $inStock;
    }
}
