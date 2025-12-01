<?php

$input    = require "input.php";
$len      = count($input);
$visited  = array_fill(0, $len, false);
$min_dist = array_map(fn(int $i): float => $i === 0 ? 0 : INF, range(0, $len - 1));
$parent   = array_fill(0, $len, -1);
$max      = -1;
$last_two = [];

$calc_distance = function (string $first, string $second): float {
    [$x1, $y1, $z1] = array_map("intval", explode(",", $first));
    [$x2, $y2, $z2] = array_map("intval", explode(",", $second));

    return sqrt(pow(($x2 - $x1), 2) + pow(($y2 - $y1), 2) + pow(($z2 - $z1), 2));
};

for ($i = 0; $i < $len; $i++) {
    $el  = -1;
    $min = INF;

    for ($j = 0; $j < $len; $j++) {
        if ($visited[$j]) {
            continue;
        }

        if ($min_dist[$j] < $min) {
            $min = $min_dist[$j];
            $el  = $j;
        }
    }

    if ($el === -1 || $min === INF) {
        break;
    }

    if ($min > $max) {
        $max      = $min;
        $last_two = [$el, $parent[$el]];
    }

    $visited[$el] = true;

    for ($j = 0; $j < $len; $j++) {
        if ($visited[$j]) {
            continue;
        }

        $dist = $calc_distance($input[$el], $input[$j]);
        if ($dist < $min_dist[$j]) {
            $min_dist[$j] = $dist;
            $parent[$j]   = $el;
        }
    }
}

var_dump((int) explode(",", $input[$last_two[0]])[0] * (int) explode(",", $input[$last_two[1]])[0]);
