<?php

$input    = require 'input.php';
$pattern  = '/(R|L)(\d+)/';
$position = 50;
$count    = 0;

$set_gauge = function (bool &$is_left, int &$value) use (&$position, &$count) {
    $position = ($is_left ? $position - $value : $position + $value) % 100;

    if ($position < 0) {
        $position = 100 - abs($position);
    }

    if ($position === 0) {
        $count++;
    }
};

for ($i = 0; $i < count($input); $i++) {
    preg_match($pattern, $input[$i], $matches);
    $is_left = $matches[1] === 'L';
    $value   = $matches[2];
    $set_gauge($is_left, $value);
}

print_r($count);
