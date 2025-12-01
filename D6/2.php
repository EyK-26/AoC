<?php

$inputs = require "input.php";
$signs  = $inputs["signs"];
$input  = $inputs["input"];
$input  = preg_split('/\n/', $input);
$total  = 0;

for ($i = 1; $i < strlen($signs); $i++) {
    if ($signs[$i] === " ") {
        $next = $signs[$i + 1] ?? null;
        if ($next === '*' || $next === '+') {
            $signs[$i] = ".";
        } else {
            $signs[$i] = $signs[$i - 1];
        }
    }
}

$signs .= str_repeat($signs[strlen($signs) - 1], 3);
$arr          = [];
$multiply_grp = 'a';

for ($i = 0; $i < strlen($signs); $i++) {
    $sign        = $signs[$i];
    $is_multiply = $sign === '*';
    if ($sign === '.') {
        $multiply_grp++;
        continue;
    }

    $str = '';
    for ($k = 0; $k < count($input); $k++) {
        $val = $input[$k][$i] ?? null;
        if (! is_null($val)) {
            $str .= trim($val);
        }
    }

    if (! empty($str)) {
        if (! $is_multiply) {
            $arr['add'] = [ ...$arr['add'] ?? [], $str];
        } else {
            $arr['mult'][$multiply_grp] = [ ...$arr['mult'][$multiply_grp] ?? [], $str];
        }
    }
}

function calc($data): int
{
    $addSum  = array_reduce($data['add'], fn($sum, $val) => $sum + (int) $val, 0);
    $multSum = array_reduce(array_values($data['mult']), function ($sum, $group) {
        return $sum + array_product(array_map('intval', $group));
    }, 0);

    return $addSum + $multSum;
}

var_dump(calc($arr));
