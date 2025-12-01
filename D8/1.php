<?php

$input  = require "input.php";
$len    = count($input);
$parent = array_map(fn(int $i): int => $i, range(0, $len - 1));

function calc_distance(string $first, string $second): float
{
    [$x1, $y1, $z1] = array_map("intval", explode(",", $first));
    [$x2, $y2, $z2] = array_map("intval", explode(",", $second));

    return sqrt(pow(($x2 - $x1), 2) + pow(($y2 - $y1), 2) + pow(($z2 - $z1), 2));
}

function find_parent($x, &$parent): int
{
    if ($parent[$x] === $x) {
        return $x;
    }

    return $parent[$x] = find_parent($parent[$x], $parent);
}

$heap = new SplPriorityQueue();
$heap->setExtractFlags(SplPriorityQueue::EXTR_BOTH);

for ($i = 0; $i < $len; $i++) {
    for ($j = $i + 1; $j < $len; $j++) {
        $dist = calc_distance($input[$i], $input[$j]);

        if ($heap->count() < $len) {
            $heap->insert([$i, $j], $dist);
        } elseif ($dist < $heap->current()["priority"]) {
            $heap->extract();
            $heap->insert([$i, $j], $dist);
        }
    }
}

foreach ($heap as $pair) {
    $i = find_parent($pair["data"][0], $parent);
    $j = find_parent($pair["data"][1], $parent);

    if ($i !== $j) {
        $parent[$i] = $j;
    }
}

$circuits = [];

for ($i = 0; $i < $len; $i++) {
    $root = find_parent($i, $parent);
    if (! isset($circuits[$root])) {
        $circuits[$root] = 0;
    }

    $circuits[$root]++;
}

rsort($circuits);
var_dump((int) $circuits[0] * (int) $circuits[1] * (int) $circuits[2]);
