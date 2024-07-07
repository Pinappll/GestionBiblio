<?php

namespace GestionBiblio\Utils;

/**
 * Classe MergeSort
 * 
 * Cette classe implémente l'algorithme de tri fusion (merge sort) pour trier un tableau.
 */
class MergeSort {
    /**
     * Trie un tableau en utilisant l'algorithme de tri fusion.
     * 
     * @param array $array Le tableau à trier.
     * @param callable $compareFunc La fonction de comparaison utilisée pour déterminer l'ordre des éléments.
     * @return array Le tableau trié.
     */
    public static function sort(array $array, callable $compareFunc) {
        if (count($array) <= 1) {
            return $array;
        }

        $middle = count($array) / 2;
        $left = array_slice($array, 0, $middle);
        $right = array_slice($array, $middle);

        $left = self::sort($left, $compareFunc);
        $right = self::sort($right, $compareFunc);

        return self::merge($left, $right, $compareFunc);
    }

    /**
     * Fusionne deux tableaux triés en un seul tableau trié.
     * 
     * @param array $left Le premier tableau trié.
     * @param array $right Le deuxième tableau trié.
     * @param callable $compareFunc La fonction de comparaison utilisée pour déterminer l'ordre des éléments.
     * @return array Le tableau fusionné et trié.
     */
    private static function merge(array $left, array $right, callable $compareFunc) {
        $result = [];
        while (count($left) > 0 && count($right) > 0) {
            if (call_user_func($compareFunc, $left[0], $right[0]) < 0) {
                $result[] = array_shift($left);
            } else {
                $result[] = array_shift($right);
            }
        }

        while (count($left) > 0) {
            $result[] = array_shift($left);
        }

        while (count($right) > 0) {
            $result[] = array_shift($right);
        }

        return $result;
    }
}