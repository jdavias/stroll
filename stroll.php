<?php

$letters = 'acdegilmnoprstuw';

$target = '945924806726376';

$max = pow(16, 9) - 1;

$hash = function($string) use ($letters) {
    $h = 7;
    for ($i = 0; $i < strlen($string) ; $i++) {
        $h = $h * 37 + strpos($letters, $string[$i]);
    }
    return $h;
};

$hex2alpha = function($number) use ($letters) {
    $string = '';
    for ($i = 0; $i < strlen($number); $i++) {
        $string .= $letters[hexdec($number[$i])];
    }
    return $string;
};

$binarySearch = function($target, $left, $right) use ($hash, $hex2alpha, &$binarySearch) {

    echo PHP_EOL . 'L:' . $left . ' R:' . $right;

    if ($left > $right) {
        return false;
    }

    $middle = floor(($left + $right) / 2);
    $alphaMiddle = $hex2alpha(dechex($middle));
    $hashedMiddle = $hash($alphaMiddle);

    if ($hashedMiddle == $target) {
        return $alphaMiddle;
    }
    elseif ($hashedMiddle > $target) {
        return $binarySearch($target, $left, $middle - 1);
    }
    else {
        return $binarySearch($target, $middle + 1, $right);
    }
};

$result = $binarySearch($target, 0, $max);

echo PHP_EOL . $result;
if ($hash($result) == $target) {
    echo PHP_EOL . 'CORRECT!';
}

?>
