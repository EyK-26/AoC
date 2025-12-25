<?php

$input = require "input.php";

$input = preg_split("/\n/", $input);

foreach ($input as $i => $line) {
    $value            = preg_split("/:/", $line);
    $input[$value[0]] = trim($value[1]);
    unset($input[$i]);
}

$total = 0;

$find = function (string $str) use ($input, &$find, &$total) {
    $count = 0;

    foreach (preg_split("/\s/", $str) as $s) {
        $input[$s] === 'out' ? $count++ : $find($input[$s]);
    }

    return $total += $count;
};

var_dump($find($input['you']));
