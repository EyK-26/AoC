<?php

$input = require "input.php";
$ranges = $input["ranges_demo"];
$count = 0;
$count_diff = 0;

$init = function () use ($count_diff, $ranges, &$count) {
  $len = count($ranges);

  for ($i = 0; $i < $len; $i++) {
    preg_match("/(\d+)-(\d+)/", $ranges[$i], $matches);
    $ranges[$i] = [
      "start" => intval($matches[1]),
      "end" => intval($matches[2]),
    ];
  }

  usort($ranges, fn($a, $b) => $a["start"] <=> $b["start"]);

  for ($i = 0; $i < $len; $i++) {
    $end = $ranges[$i]["end"];
    $next_start = $i + 1 < $len ? $ranges[$i + 1]["start"] : PHP_INT_MAX;
    if ($end > $next_start) {
      $count_diff = $next_start - $end - 1;
    }
  }

  $start = $ranges[0]["start"];
  $end = $ranges[$len - 1]["end"];
  $count = $end - $start + $count_diff;
};

$init();
var_dump($count);
