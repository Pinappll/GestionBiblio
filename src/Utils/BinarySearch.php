<?php

namespace GestionBiblio\Utils;

/**
 * Classe BinarySearch
 * 
 * Cette classe implémente l'algorithme de recherche binaire pour rechercher des livres dans un tableau donné.
 */
class BinarySearch {
    /**
     * Recherche les livres correspondant au terme de recherche dans le tableau donné.
     * 
     * @param array $books Le tableau de livres dans lequel effectuer la recherche.
     * @param string $column La colonne sur laquelle effectuer la recherche (id, name, description, inStock).
     * @param string $searchTerm Le terme de recherche.
     * @return array Les livres correspondant au terme de recherche.
     */
    public static function search(array $books, string $column, string $searchTerm) {
        $left = 0;
        $right = count($books) - 1;
        $foundBooks = [];

        while ($left <= $right) {
            $mid = (int) (($left + $right) / 2);
            $book = $books[$mid];
            $compareValue = self::getBookColumnValue($book, $column);

            if (stripos($compareValue, $searchTerm) !== false) {
                $foundBooks[] = $book;

                $i = $mid - 1;
                while ($i >= 0 && stripos(self::getBookColumnValue($books[$i], $column), $searchTerm) !== false) {
                    $foundBooks[] = $books[$i];
                    $i--;
                }

                $i = $mid + 1;
                while ($i < count($books) && stripos(self::getBookColumnValue($books[$i], $column), $searchTerm) !== false) {
                    $foundBooks[] = $books[$i];
                    $i++;
                }

                break;
            }

            if ($compareValue < $searchTerm) {
                $left = $mid + 1;
            } else {
                $right = $mid - 1;
            }
        }

        return $foundBooks;
    }

    /**
     * Récupère la valeur de la colonne spécifiée pour un livre donné.
     * 
     * @param mixed $book Le livre pour lequel récupérer la valeur de la colonne.
     * @param string $column La colonne dont récupérer la valeur (id, name, description, inStock).
     * @return string La valeur de la colonne pour le livre donné.
     */
    private static function getBookColumnValue($book, $column) {
        switch ($column) {
            case 'id':
                return $book->getId();
            case 'name':
                return $book->getName();
            case 'description':
                return $book->getDescription();
            case 'inStock':
                return $book->isInStock() ? '1' : '0';
            default:
                return '';
        }
    }
}
?>
