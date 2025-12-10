<?php

$inputs = require "input.php";
$input = $inputs["input"];
$input_demo = $inputs["input_demo"];

$starting_pos = strpos($input[0], 'S');

for ($i = 2; $i < count($input); $i++) {
  if ($i % 2 !== 0) continue;
  $str = $input[$i];
  for ($k = 2; $k < strlen($str); $k++) {
    
  }
}
var_dump($starting_pos);
