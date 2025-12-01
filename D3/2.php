<?php

$input   = require 'input.php';
$counter = 0;
$offset  = $offset_org  = 0;
$str     = "";

function inner_cb(string $string): void
{
    global $str, $offset, $offset_org, $counter;
    $num = 0;
    $lim = strlen($string) - $offset;
    $pos = 0;

    for ($i = 0; $i < strlen($string); $i++) {
        $val = $string[$i];
        if ($val > $num && $i <= $lim) {
            $num = $val;
            $pos = $i;
        }
    }

    $str .= strval($num);
    if (strlen($str) < $offset_org) {
        $offset--;
        inner_cb(substr($string, $pos + 1));
    } else {
        $counter += $str;
        $offset = $offset_org;
        $str    = "";
    }
}

function iterate_inputs(array $arr, int $lim): void
{
    global $offset, $offset_org;
    $offset     = $lim;
    $offset_org = $offset;

    foreach ($arr as $val) {
        inner_cb($val);
    }
}

iterate_inputs($input, 12);
var_dump($counter);
