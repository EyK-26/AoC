<?php

$input = require "input.php";
$input = [
    "7,1",
    "11,1",
    "11,7",
    "9,7",
    "9,5",
    "2,5",
    "2,3",
    "7,3",
];
$inputs = [];
$map    = [];

foreach ($input as $str) {
    $coords                           = explode(',', trim($str));
    $inputs[]                         = $coords;
    $map["{$coords[0]}-{$coords[1]}"] = true;
}

$val  = 0;
$area = fn(array $p1, array $p2): int => (abs($p2[0] - $p1[0]) + 1) * (abs($p2[1] - $p1[1]) + 1);
$init = function (array $points) use ($area, &$val, $map): int {
    $count = count($points);
    for ($i = 0; $i < $count; $i++) {
        for ($j = $i + 1; $j < $count; $j++) {
            $curr   = $points[$i];
            $next   = $points[$j];
            $c1_key = "{$next[0]}-{$curr[1]}";
            $c2_key = "{$curr[0]}-{$next[1]}";

            if (isset($map[$c1_key]) && isset($map[$c2_key])) {
                $new = $area($curr, $next);
                if ($new > $val) {
                    $val = $new;
                }
            }
        }
    }

    return $val;
};

var_dump($init($inputs));
