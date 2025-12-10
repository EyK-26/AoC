<?php

$input = require "input.php";
$ranges = $input["ranges_demo"];
$count = 0;

$init = function () use (&$ranges, &$count) {
	$len = count($ranges);

	for ($i = 0; $i < $len; $i++) {
		preg_match("/(\d+)-(\d+)/", $ranges[$i], $matches);
		$ranges[$i] = [
			"start" => $matches[1],
			"end" => $matches[2],
		];
	}

	usort($ranges, fn($a, $b) => $a["start"] <=> $b["start"]);

	for ($i = 0; $i < $len; $i++) {
		$start = $ranges[$i]["start"];
		$end = $ranges[$i]["end"];
		$count += $end - $start + 1;
		$next_start = $i + 1 < $len ? $ranges[$i + 1]["start"] : PHP_INT_MAX;
		if ($end > $next_start) {
			$count += $next_start - $end - 1;
		}
	}
};

$init();
var_dump($count);
