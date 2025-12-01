<?php

$input = require "input.php";

$input = preg_split("/\n/", $input);

foreach ($input as $i => $line) {
    $value            = preg_split("/:/", $line);
    $input[$value[0]] = preg_split("/\s/", trim($value[1]));
    unset($input[$i]);
}

$visited    = [];
$find_paths = function (string $str, int $fft_val, int $dac_val) use (&$input, &$find_paths, &$visited): int {
    $count = 0;
    if ($str === 'out') {
        return $fft_val && $dac_val;
    }
    $key = "$str::$fft_val$dac_val";
    if (isset($visited[$key])) {
        return $visited[$key];
    }

    foreach ($input[$str] as $next_str) {
        $count += $find_paths(
            $next_str,
            $fft_val || ($next_str === 'fft'),
            $dac_val || ($next_str === 'dac')
        );
    }

    return $visited[$key] = $count;
};

var_dump($find_paths('svr', 0, 0));
