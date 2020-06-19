<?php

namespace App\ValueObject;

use InvalidArgumentException;

class Atom
{
    const VALID_SYMBOL = ['Ca', 'Cf', 'C', 'Ce', 'Cs', 'Cl', 'Cr', 'Co', 'Cn', 'Cu', 'Cm', 'Ds', 'Db', 'Dy', 'Es', 'Er', 'Eu', 'Fm', 'Fl', 'F', 'Fr', 'Gd', 'Ga', 'Ge', 'Au', 'Hf', 'Hs', 'He', 'Ho', 'H', 'In', 'I', 'Ir', 'Fe', 'Kr', 'La', 'Lr', 'Pb', 'Li', 'Lv', 'Lu', 'Mg', 'Mn', 'Mt', 'Md', 'Hg', 'Mo', 'Mc', 'Nd', 'Ne', 'Np', 'Ni', 'Nh', 'Nb', 'N', 'No', 'Og', 'Os', 'O', 'Pd', 'P', 'Pt', 'Pu', 'Po', 'K', 'Pr', 'Pm', 'Pa', 'Ra', 'Rn', 'Re', 'Rh', 'Rg', 'Rb', 'Ru', 'Rf', 'Sm', 'Sc', 'Sg', 'Se', 'Si', 'Ag', 'Na', 'Sr', 'S', 'Ta', 'Tc', 'Te', 'Ts', 'Tb', 'Tl', 'Th', 'Tm', 'Sn', 'Ti', 'W', 'U', 'V', 'Xe', 'Yb', 'Y', 'Zn', 'Zr'];

    /**
     * @var string
     */
    protected $symbol;

    /**
     * @var int
     */
    protected $count;

    public function __construct(string $symbol, ?int $count = 1)
    {
        if (!in_array($symbol, self::VALID_SYMBOL)) {
            throw new InvalidArgumentException(sprintf('symbol given %s is unknown', $symbol));
        }

        if (0 >= $count) {
            throw new InvalidArgumentException(sprintf('count given %d is invalid', $symbol));
        }

        $this->symbol = $symbol;
        $this->count = $count;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function increase(int $nb): self
    {
        $this->count += $nb;

        return $this;
    }

    public function multiply(int $factor): self
    {
        $this->count = $this->count * $factor;

        return $this;
    }
}
