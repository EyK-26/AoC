<?php

$inputs = require "input.php";
$signs  = $inputs["signs"];
$input  = $inputs["input"];

$signs_arr     = preg_split('/\s+/', $signs);
$len           = count($signs_arr);
$inputs_mapped = array_chunk(preg_split('/\s+/', $input), $len);
$total         = 0;

for ($i = 0; $i < $len; $i++) {
    $is_multiply = $signs_arr[$i] === '*';
    $count       = $is_multiply ? 1 : 0;

    for ($k = 0; $k < count($inputs_mapped); $k++) {
        $val = $inputs_mapped[$k][$i];
        if ($is_multiply) {
            $count *= $val;
        } else {
            $count += $val;
        }
    }

    $total += $count;
}

var_dump($total);
