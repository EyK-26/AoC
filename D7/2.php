<?php

$inputs    = require "input.php";
$input     = $inputs["input"];
$timelines = 0;
array_pop($input);

$set_val = function (array $arr): string | array {
    $sum = 0;

    foreach ($arr as $item) {
        if (is_array($item)) {
            $sum += $item['val'];
        } elseif (is_numeric($item)) {
            $sum += (int) $item;
        }
    }

    if ($sum < 10) {
        return (string) $sum;
    }

    return ['val' => $sum];
};

foreach ($input as &$row) {
    $row = str_split($row);
}

$input[0] = array_map(fn($el) => $el === 'S' ? '1' : $el, $input[0]);

for ($i = 1; $i < count($input); $i++) {
    $arr      = &$input[$i];
    $arr_prev = $input[$i - 1];

    for ($k = 0; $k < count($arr); $k++) {
        $curr       = $arr[$k];
        $prev       = $arr[$k - 1] ?? null;
        $next       = $arr[$k + 1] ?? null;
        $prev_upper = $arr_prev[$k - 1] ?? null;
        $next_upper = $arr_prev[$k + 1] ?? null;

        if ($curr === "^") {
            $arr[$k - 1] ??= $arr_prev[$k];
            $arr[$k + 1] ??= $arr_prev[$k];
        } elseif ($prev === "^" && $next === "^") {
            $arr[$k] = $set_val([$prev_upper, $next_upper, $arr_prev[$k]]);
        } elseif ($prev === "^") {
            $arr[$k] = $set_val([$prev_upper, $arr_prev[$k]]);
        } elseif ($next === "^") {
            $arr[$k] = $set_val([$next_upper, $arr_prev[$k]]);
        } else {
            $arr[$k] = $arr_prev[$k];
        }
    }
}

$total = 0;
foreach (end($input) as $row) {
    if (is_array($row)) {
        $total += $row['val'];
    } else if (is_numeric($row)) {
        $total += (int) $row;
    }
}

echo $total . PHP_EOL;
