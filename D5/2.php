<?php

$input  = require "input.php";
$ranges = $input["ranges"];
$count  = 0;
$arr    = [];

$init = function () use (&$ranges, &$count, &$arr) {
    $len = count($ranges);

    for ($i = 0; $i < $len; $i++) {
        preg_match("/(\d+)-(\d+)/", $ranges[$i], $matches);
        $ranges[$i] = [
            "start" => (int) $matches[1],
            "end"   => (int) $matches[2],
        ];
    }

    usort($ranges, fn($a, $b) => $a["start"] <=> $b["start"]);
    $arr = [$ranges[0]];

    for ($i = 1; $i < $len; $i++) {
        $last = &$arr[count($arr) - 1];
        $curr = $ranges[$i];
        if ($last["end"] > $curr["start"]) {
            $last["end"] = max($last["end"], $curr["end"]);
            continue;
        }
        array_push($arr, $curr);
    }

    for ($i = 0; $i < count($arr); $i++) {
        $count += ($arr[$i]["end"] - $arr[$i]["start"]) + 1;
    }
};

$init();
var_dump($count);
