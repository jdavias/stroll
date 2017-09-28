<?php

class Hasher {

    private $letters;
    private $base;

    public function __construct($letters) {
        $this->letters = $letters;
        $this->base = strlen($this->letters);
    }

    public function letters() {
        return $this->letters;
    }

   /**
    * Returns the n-th arrangement of letters from $letters.
    *
    * The decimal rank is converted to the base which radix is equal to the length of $letters.
    * Each character of the string representation of the converted rank is then converted back
    * to 10-base, and used as an index in $letters to create the word.
    */
    public function nthWord($rank) {

        $number = base_convert($rank, 10, $this->base);

        $string = '';
        for ($i = 0; $i < strlen($number); $i++) {
            $string .= $this->letters[base_convert($number[$i], $this->base, 10)];
        }
        return $string;
    }

    public function hash($word) {
        $h = 7;
        for ($i = 0; $i < strlen($word) ; $i++) {
            $h = $h * 37 + strpos($this->letters, $word[$i]);
        }
        return $h;
    }
}

class HashBinarySearch {

    private $hasher;

    public function __construct(Hasher $hasher) {
        $this->hasher = $hasher;
    }

    public function find($target) {
        $max = pow(strlen($this->hasher->letters()), strlen($target)) - 1;
        return $this->search($target, 0, $max);
    }

    public function search($target, $left, $right) {

        if ($left > $right) {
            return false;
        }

        $middle = floor(($left + $right) / 2);
        $alphaMiddle = $this->hasher->nthWord($middle);
        $hashedMiddle = $this->hasher->hash($alphaMiddle);

        if ($hashedMiddle == $target) {
            return $alphaMiddle;
        }
        elseif ($hashedMiddle > $target) {
            return $this->search($target, $left, $middle - 1);
        }
        else {
            return $this->search($target, $middle + 1, $right);
        }
    }
}

$search = new HashBinarySearch(new Hasher('acdegilmnoprstuw'));

echo $search->find('945924806726376');
echo PHP_EOL;

?>
