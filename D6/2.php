<?php

$inputs = require "input.php";
$signs = $inputs["signs_demo"];
$input = $inputs["input_demo"];

$inputs_mapped = array_chunk(preg_split('/\s+/', $input), count(preg_split('/\s+/', $signs)));
$signs_arr = preg_split('/\s+/', $signs);
$total = 0;

for ($j = 0; $j < count($inputs_mapped); $j++) {
  $inputs_mapped[$j] = array_map(fn(int $val) => str_split(strval($val)), $inputs_mapped[$j]);
}

for ($i = 0; $i < count($signs_arr); $i++) {
  $is_multiply = $signs_arr[$i] === '*';
  $count = $is_multiply ? 1 : 0;

  for ($k = 0; $k < count($inputs_mapped); $k++) {
  }

  $total += $count;
}

var_dump($total);
