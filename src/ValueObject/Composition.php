<?php

namespace App\ValueObject;

use JsonSerializable;

class Composition implements JsonSerializable
{
    /**
     * @var array
     */
    protected $atoms = [];

    public function merge(Composition $composition): Composition
    {
        foreach ($composition->getAtoms() as $atom) {
            $this->addAtom($atom);
        }

        return $this;
    }

    public function addAtom(Atom $atom): self
    {
        if ($this->has($atom)) {
            $this->atoms[$atom->getSymbol()]->increase($atom->getCount());
        } else {
            $this->atoms[$atom->getSymbol()] = new Atom($atom->getSymbol(), $atom->getCount());
        }

        return $this;
    }

    public function multiply(int $factor): self
    {
        foreach ($this->getAtoms() as $atom) {
            $atom->multiply($factor);
        }

        return $this;
    }

    public function has(Atom $atom): bool
    {
        return array_key_exists($atom->getSymbol(), $this->atoms);
    }

    public function getAtoms(): array
    {
        return $this->atoms;
    }

    public function jsonSerialize()
    {
        $data = [];

        foreach ($this->atoms as $key => $atom) {
            $data[$key] = $atom->getCount();
        }

        return $data;
    }
}
