<?php

namespace App\ValueObject;

final class Molecule
{
    /**
     * @var string
     */
    protected $expression;

    public function __construct(string $expression)
    {
        $this->expression = $expression;
    }

    public function getExpression(): string
    {
        return $this->expression;
    }
}
