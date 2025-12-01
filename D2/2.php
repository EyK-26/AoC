<?php

$input   = require 'input.php';
$pattern = "/(\d+)-(\d+)/";
$count   = 0;

function check_pattern(int $num): bool
{
    $len_count = 1;
    $str_arr   = str_split(strval($num));
    while ($len_count < count($str_arr)) {
        $array_cut = array_chunk($str_arr, $len_count);
        if (array_all($array_cut, fn(array $arr) => $array_cut[0] === $arr)) {
            return true;
        }
        $len_count++;
    }
    return false;
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
