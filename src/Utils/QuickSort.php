<?php
namespace GestionBiblio\Utils;

class QuickSort {
    public static function sort(array $array, callable $compareFunc) {
        if (count($array) < 2) {
            return $array;
        }
        $left = $right = [];
        reset($array);
        $pivot_key = key($array);
        $pivot = array_shift($array);
        foreach ($array as $k => $v) {
            if (call_user_func($compareFunc, $v, $pivot) < 0) {
                $left[$k] = $v;
            } else {
                $right[$k] = $v;
            }
        }
        return array_merge(self::sort($left, $compareFunc), array($pivot_key => $pivot), self::sort($right, $compareFunc));
    }
}