<?php

$inputs = require "input.php";
$input = $inputs["input_demo"];
$starting_pos = strpos($input[0], 'S');
$beams = [$starting_pos + 1, $starting_pos - 1];

for ($i = 4; $i < count($input); $i++) {
  if ($i % 2 !== 0) continue;
  $str = $input[$i];
  for ($k = 2; $k < strlen($str); $k++) {
    $char = $str[$k];
    if ($char === '^' && array_find($beams, fn(int $idx) => $idx === $k)) {
      $beams = array_diff($beams, [$k]);
      array_push($beams, $k + 1, $k - 1);
    }
  }
}
var_dump($beams);
