<?php

$input         = require 'input.php';
$ranges        = $input['ranges'];
$ids           = $input['ids'];
$total         = 0;
$isWithinRange = fn(int $number, int $min, int $max): bool => $number >= $min && $number <= $max;
$found         = [];

for ($k = 0; $k < count($ids); $k++) {
    $val = $ids[$k];
    if (array_find($found, fn(int $num) => $val === $num)) {
        continue;
    }
    for ($i = 0; $i < count($ranges); $i++) {
        preg_match('/(\d+)-(\d+)/', $ranges[$i], $matches);
        if ($isWithinRange($val, $matches[1], $matches[2])) {
            array_push($found, (string) $val);
            $total++;
            break;
        }
    }
}

var_dump($total);
