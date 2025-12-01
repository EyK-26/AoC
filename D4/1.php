<?php

$input   = require 'input.php';
$total   = 0;
$arr_len = count($input);

$init = function () use ($input, &$total, $arr_len) {
    for ($i = 0; $i < $arr_len; $i++) {
        $str     = $input[$i];
        $str_len = strlen($str);

        for ($k = 0; $k < $str_len; $k++) {
            $b  = $i + 1 < $arr_len ? $input[$i + 1][$k] : "";
            $t  = $i - 1 >= 0 ? $input[$i - 1][$k] : "";
            $r  = $k + 1 < $str_len ? $str[$k + 1] : "";
            $l  = $k - 1 >= 0 ? $str[$k - 1] : "";
            $br = $i + 1 < $arr_len && $k + 1 < $str_len ? $input[$i + 1][$k + 1] : "";
            $bl = $i + 1 < $arr_len && $k - 1 >= 0 ? $input[$i + 1][$k - 1] : "";
            $tr = $i - 1 >= 0 && $k + 1 < $str_len ? $input[$i - 1][$k + 1] : "";
            $tl = $k - 1 >= 0 && $i - 1 >= 0 ? $input[$i - 1][$k - 1] : "";

            if ($str[$k] !== "@") {
                continue;
            }

            if (substr_count("$b$t$r$l$br$bl$tr$tl", "@") < 4) {
                $total++;
            }
        }
    }
};

$init();
var_dump($total);
