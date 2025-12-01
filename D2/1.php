<?php

$input   = require 'input.php';
$pattern = "/(\d+)-(\d+)/";
$count   = 0;

function check_pattern(int $num): bool
{
    $str_arr   = str_split(strval($num));
    $array_cut = array_chunk($str_arr, ceil(count($str_arr) / 2));
    if (! isset($array_cut[1])) {
        return false;
    }
    return $array_cut[0] == $array_cut[1];
}

$count_seq = function (int $start, int $end) use (&$count) {
    while ($start <= $end) {
        if (check_pattern($start)) {
            $count += $start;
        }
        $start++;
    }
};

for ($i = 0; $i < count($input); $i++) {
    preg_match($pattern, $input[$i], $matches);
    $start = $matches[1];
    $end   = $matches[2];
    $count_seq($start, $end);
}

print_r($count);
