<?php

namespace App\Parser;

use App\ValueObject\Atom;
use App\ValueObject\Composition;
use InvalidArgumentException;

class ExpressionParser
{
    private $pointer = 0;

    public function parse(string $expression, $position = 0): Composition
    {
        $result = new Composition();

        $symbol = '';
        $length = strlen($expression);

        $number = 1;
        $loop = 0;

        for ($position; $position < $length; $position++) {
            $token = $expression[$position];
            switch (true) {
                case $this->isOpeningBracket($token):
                    $result = $result->merge($this->parse($expression, $position + 1));
                    $position = $this->pointer;
                    break;
                case $this->isClosingBracket($token):
                    if (!empty($symbol)) {
                        $result->addAtom(new Atom($symbol, $number));
                        $number = 1;
                        $loop = 0;
                        $symbol = '';
                    }
                    if (($position + 1) < $length && is_numeric($expression[$position + 1])) {
                        $result = $result->multiply($expression[$position + 1]);
                        $this->pointer = $position + 1;
                    } else {
                        $this->pointer = $position;
                    }

                    return $result;
                case is_numeric($token):
                    if (1 === $number && $loop === 0) {
                        $number = (int) $token;
                    } else {
                        $number = $number * 10 + $token;
                    }
                    $loop++;
                    break;
                case ctype_upper($token):
                    if (!empty($symbol)) {
                        $result->addAtom(new Atom($symbol, $number));
                        $number = 1;
                        $loop = 0;
                    }
                    $symbol = $token;
                    break;
                case ctype_lower($token):
                    $symbol .= $token;
                    break;
                default:
                    throw new InvalidArgumentException(sprintf('Token %s not valid', $token));
            }
        }

        if (!empty($symbol)) {
            $result->addAtom(new Atom($symbol, $number));
        }

        return $result;
    }

    private function isOpeningBracket(string $string): bool
    {
        return
            '(' === $string ||
            '{' === $string ||
            '[' === $string;
    }

    private function isClosingBracket(string $string): bool
    {
        return
            ')' === $string ||
            '}' === $string ||
            ']' === $string;
    }
}
