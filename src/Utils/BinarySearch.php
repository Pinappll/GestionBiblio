<?php

namespace GestionBiblio\Utils;

class BinarySearch {
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
