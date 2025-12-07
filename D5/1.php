<?php

$input = require 'input.php';
$ranges  = $input['ranges'];
$ids = $input['ids'];
$ranges_demo  = $input['ranges_demo'];
$ids_demo  = $input['ids_demo'];

$pattern = '/(\d+)-(\d+)/';
$total = 0;

for ($i = 0; $i < count($ranges_demo); $i++) {
	preg_match($pattern, $ranges_demo[$i], $matches);
	$start = intval($matches[1]);
	$end = intval($matches[2]);
	while ($start <= $end) {
		if (array_any($ids_demo, fn(int $val) => $val === $start)) {
			$ids_demo = array_filter($ids_demo, fn(int $val) => $val !== $start);
			echo "found $start";
			$total++;
			break;
		}
		$start++;
	}
}


var_dump($total);
