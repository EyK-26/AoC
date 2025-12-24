<?php

$inputs = require "input.php"; // [ "[.###.#] / (0,1,2,3,4) (0,3,4) (0,1,2,4,5) (1,2) / {10,11,11,5,10,5}" ];
$total  = 0;

function backtrack($arr, $start, $current, &$result): void
{
    if (! empty($current)) {
        $result[] = $current;
    }

    for ($i = $start; $i < count($arr); $i++) {
        $current[] = $arr[$i];
        backtrack($arr, $i + 1, $current, $result);
        array_pop($current);
    }
}

function generate_subsets($arr): array
{
    $result = [];
    backtrack($arr, 0, [], $result);

    return $result;
}

function get_count(array $buttons, string $positions): int
{
    $input  = implode('', $buttons);
    $output = '';
    for ($i = 0; $i < strlen($input); $i++) {
        $char = $input[$i];
        if ($char === ',') {
            continue;
        }

        if (substr_count($input, $char) % 2 !== 0) {
            $output .= $char;
        }
    }

    $arr = array_unique(str_split($output));
    sort($arr);
    if (implode('', $arr) === $positions) {
        return count($buttons);
    }
    return 0;
}

$init = function (array $inputs) use (&$total) {
    foreach ($inputs as $input) {
        preg_match('/(.*)\/(.*)\/(.*)/', $input, $m);
        $pattern = trim($m[1]);
        $numbers = trim($m[2]);
        preg_match_all('/[.#]/', $pattern, $n);
        $positions = implode(
            '',
            array_map(fn(array $arr) => array_keys(array_filter($arr, fn(string $char) => $char === '#')), $n)[0]
        );
        preg_match_all('/\d+(?:,\d+)*/', $numbers, $t);
        $count = 0;
        $first = true;
        foreach (generate_subsets($t[0]) as $subset) {
            $res = get_count($subset, $positions);
            if ($count === 1) {
                break;
            }

            if ($res > 0) {
                if ($first) {
                    $count = $res;
                    $first = false;
                } else {
                    $count = min($count, $res);
                }
            }
        }
        $total += $count;
    }

    return $total;
};

var_dump($init($inputs));
