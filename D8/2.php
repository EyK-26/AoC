<?php

$input = require "input.php";

function calc_distance(string $first, string $second): float
{
    [$x1, $y1, $z1] = array_map("intval", explode(",", $first));
    [$x2, $y2, $z2] = array_map("intval", explode(",", $second));

    return sqrt(pow($x2 - $x1, 2) + pow($y2 - $y1, 2) + pow($z2 - $z1, 2));
}

function set_min_val($min_dist, &$visited, &$current): float
{

    $min_value = INF;

    for ($i = 0; $i < count($visited); $i++) {
        if ($visited[$i] || $min_dist[$i] >= $min_value) {
            continue;
        }

        $min_value = $min_dist[$i];
        $current   = $i;
    }

    $visited[$current] = true;

    return $min_value;
}

function set_min_dist($input, &$min_dist, $visited, &$parent_node, $current): void
{
    for ($i = 0; $i < count($input); $i++) {
        if ($visited[$i]) {
            continue;
        }

        $dist = calc_distance($input[$current], $input[$i]);

        if ($dist < $min_dist[$i]) {
            $min_dist[$i] = $dist;
            $parent_node[$i]   = $current;
        }
    }
}

function track_max_edge($current, &$max_edge_nodes, $min_value, &$max_value, $parent_node): void
{
    if ($min_value < $max_value) {
        return;
    }
    $max_value      = $min_value;
    $max_edge_nodes = [$current, $parent_node[$current]];
}

function calc_mst($input, $min_dist, $visited, $parent_node): int
{
    $max_value      = -1;
    $max_edge_nodes = [];
    $current        = -1;

    for ($i = 0; $i < count($input); $i++) {
        $min_value = set_min_val($min_dist, $visited, $current);
        set_min_dist($input, $min_dist, $visited, $parent_node, $current);
        track_max_edge($current, $max_edge_nodes, $min_value, $max_value, $parent_node);
    }

    return (int) explode(",", $input[$max_edge_nodes[0]])[0] * (int) explode(",", $input[$max_edge_nodes[1]])[0];
}

$init = function ($input): int {
    $len        = count($input);
    $min_dist = array_map(fn(int $i): float => $i === 0 ? 0 : INF, range(0, $len - 1));
    $visited       = array_fill(0, $len, false);
    $parent_node   = array_fill(0, $len, -1);

    return calc_mst($input, $min_dist, $visited, $parent_node);
};

var_dump($init($input));
