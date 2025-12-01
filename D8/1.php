<?php

$input = require "input.php";

function calc_distance(string $first, string $second): float
{
    [$x1, $y1, $z1] = array_map("intval", explode(",", $first));
    [$x2, $y2, $z2] = array_map("intval", explode(",", $second));

    return sqrt(pow($x2 - $x1, 2) + pow($y2 - $y1, 2) + pow($z2 - $z1, 2));
}

function find($n, &$parent): int
{
    if ($parent[$n] !== $n) {
        return $parent[$n] = find($parent[$n], $parent);
    }

    return $n;
}

function set_edges($input): SplPriorityQueue
{
    $heap = new SplPriorityQueue();
    $heap->setExtractFlags(SplPriorityQueue::EXTR_BOTH);
    $len = count($input);

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

    return $heap;
}

function merge_comp($heap, &$parent): void
{
    foreach ($heap as $pair) {
        $first  = find($pair["data"][0], $parent);
        $second = find($pair["data"][1], $parent);

        if ($first !== $second) {
            $parent[$first] = $second;
        }
    }
}

function count_comp($parent): array
{
    $count = [];

    for ($i = 0; $i < count($parent); $i++) {
        $root = find($i, $parent);
        if (! isset($count[$root])) {
            $count[$root] = 0;
        }

        $count[$root]++;
    }

    rsort($count);
    return $count;
}

function calc($count): int
{
    $product = 1;

    for ($i = 0; $i < 3; $i++) {
        $product *= $count[$i];
    }

    return $product;
}

$init = function ($input): int {
    $len    = count($input);
    $parent    = array_map(fn(int $i): int => $i, range(0, $len - 1));
    $edges = set_edges($input);
    merge_comp($edges, $parent);
    $count = count_comp($parent);
    $result           = calc($count);

    return $result;
};

var_dump($init($input));
