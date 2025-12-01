<?php

$input = require "input.php";
$c     = [];

foreach ($input as $str) {
    $c[] = explode(',', $str);
}

$len  = count($c);
$area = fn(array $p1, array $p2): int => (abs($p2[0] - $p1[0]) + 1) * (abs($p2[1] - $p1[1]) + 1);
$init = function (array $points) use ($area, $len): int {
    $val = 0;

    for ($i = 0; $i < $len; $i++)
        for ($j = $i + 1; $j < $len; $j++)
            $val = max($val, $area($points[$i], $points[$j]));

    return $val;
};

var_dump($init($c));
