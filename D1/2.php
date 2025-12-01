<?php

$input         = require 'input.php';
$pattern       = '/(R|L)(\d+)/';
$position      = 50;
$prev_position = $position;
$count         = 0;

$set_gauge = function (bool &$is_left, int &$value) use (&$position, &$count, &$prev_position) {
    $position = ($is_left ? $position - $value : $position + $value) % 100;

    if ($position < 0) {
        $position = 100 - abs($position);
    }

    if ($value > 99) {
        $count += floor($value / 100);
    }

    if ($position === 0) {
        $count++;
    } else {
        if ($prev_position > 0) {
            if (! $is_left && $prev_position + ($value % 100) > 99) {
                $count++;
            } else if ($is_left && $prev_position - ($value % 100) < 0) {
                $count++;
            }
        }
    }

    $prev_position = $position;
};

for ($i = 0; $i < count($input); $i++) {
    preg_match($pattern, $input[$i], $matches);
    $is_left = $matches[1] === 'L';
    $value   = $matches[2];
    $set_gauge($is_left, $value);
}

print_r($count);
