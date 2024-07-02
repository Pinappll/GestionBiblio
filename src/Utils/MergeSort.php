<?php

namespace GestionBiblio\Utils;

class MergeSort {
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