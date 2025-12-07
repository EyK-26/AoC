<?php

$input = require 'input.php';
$ranges = $input['ranges_demo'];
$count = 0;

$init = function () use (&$ranges, &$count) {
	$len = count($ranges);

	for ($i = 0; $i < $len; $i++) {
		preg_match('/(\d+)-(\d+)/', $ranges[$i], $matches);
		$ranges[$i] = [
			'start' => intval($matches[1]),
			'end' => intval($matches[2])
		];
	}

	usort($ranges, fn($a, $b) => $a['start'] <=> $b['start']);

	for ($i = 0; $i < $len; $i++) {
		$start = $ranges[$i]['start'];
		$end = $ranges[$i]['end'];
		$prev_end = $i - 1 >= 0 ? $ranges[$i - 1]['end'] : 0;
		$next_start = $i + 1 < $len ? $ranges[$i + 1]['start'] : PHP_INT_MAX;
		if ($start > $prev_end && $end < $next_start) {
			var_dump($start, $end, $prev_end, $next_start);
			$count += ($end - $start) + 1;
		}
	}
};

$init();
var_dump($count);
