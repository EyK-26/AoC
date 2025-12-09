<?php

$inputs = require "input.php";
$signs = $inputs["signs_demo"];
$input = $inputs["input_demo"];

$inputs_mapped = array_chunk(preg_split('/\s+/', $input), count(preg_split('/\s+/', $signs)));
$signs_arr = preg_split('/\s+/', $signs);
$total = 0;

for ($j = 0; $j < count($inputs_mapped); $j++) {
  $inputs_mapped[$j] = array_map(fn (int $val) => str_split(strval($val)), $inputs_mapped[$j]);
}

$new_arr = [];

for ($i = 0; $i < count($signs_arr); $i++) {
  $is_multiply = $signs_arr[$i] === '*';
  $count = $is_multiply ? 1 : 0;

  for ($k = 0; $k <= count($inputs_mapped); $k++) {
    $inner_arr = $inputs_mapped[$i][$k];
    $inner_arr['op'] = $is_multiply ? '*': '+';
    if (count($inner_arr) > 1) array_push($new_arr, $inner_arr);
  }
}

var_dump($new_arr);
