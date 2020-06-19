<?php

namespace App\Tests\ValueObject;

use App\ValueObject\Atom;
use PHPUnit\Framework\TestCase;

class AtomTest extends TestCase
{
    public function testConstruct(): void
    {
        $atom = new Atom('Fe', 5);
        $this->assertEquals('Fe', $atom->getSymbol());
        $this->assertEquals(5, $atom->getCount());

        $atom = new Atom('Fe');
        $this->assertEquals('Fe', $atom->getSymbol());
        $this->assertEquals(1, $atom->getCount());

        $atom = new Atom('Mg', 3);
        $this->assertEquals('Mg', $atom->getSymbol());
        $this->assertEquals(3, $atom->getCount());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructShouldThrowExceptionWrongSymbol(): void
    {
        $atom = new Atom('unknown');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructShouldThrowExceptionWrongCount(): void
    {
        $atom = new Atom('Fe', -5);
    }

    public function testIncrease(): void
    {
        $atom = new Atom('Mg', 5);

        $atom
            ->increase(1)
            ->increase(1)
            ->increase(1)
        ;

        $this->assertEquals(8, $atom->getCount());
    }

    public function testMultiply(): void
    {
        $atom = new Atom('Mg', 5);

        $atom
            ->multiply(1)
            ->multiply(2)
            ->multiply(3)
        ;

        $this->assertEquals(30, $atom->getCount());
    }
}
