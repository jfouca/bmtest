<?php

namespace App\Tests\ValueObject;

use App\ValueObject\Atom;
use App\ValueObject\Composition;
use PHPUnit\Framework\TestCase;

class CompositionTest extends TestCase
{
    /**
     * @var Composition
     */
    private $composition;

    public function setUp(): void
    {
        $this->composition = new Composition();
    }

    public function testConstruct(): void
    {
        $this->assertEmpty($this->composition->getAtoms());
    }

    public function testAddAtom(): void
    {
        $this->composition->addAtom(new Atom('Fe', 3));

        $this->assertNotEmpty($this->composition->getAtoms());
        $this->assertCount(1, $this->composition->getAtoms());
        $this->assertTrue($this->composition->has(new Atom('Fe')));

        $this->assertInstanceOf(Atom::class, $this->composition->getAtoms()['Fe']);
        $this->assertEquals(3, $this->composition->getAtoms()['Fe']->getCount());
        $this->assertEquals('Fe', $this->composition->getAtoms()['Fe']->getSymbol());

        $this->composition->addAtom(new Atom('Fe', 1));
        $this->assertEquals(4, $this->composition->getAtoms()['Fe']->getCount());
    }

    public function testMultiply(): void
    {
        $result = $this->composition->addAtom(new Atom('Fe', 3))->multiply(3);

        $this->assertInstanceOf(Composition::class, $result);
        $this->assertCount(1, $result->getAtoms());
        $this->assertEquals(9, $result->getAtoms()['Fe']->getCount());
    }

    public function testMerge(): void
    {
        $this->composition
            ->addAtom(new Atom('Fe', 1))
            ->addAtom(new Atom('Mg', 2))
            ->addAtom(new Atom('U', 3))
        ;

        $next = new Composition();
        $next
            ->addAtom(new Atom('Fe', 5))
            ->addAtom(new Atom('Mg', 1))
            ->addAtom(new Atom('La', 2))
        ;

        $result = $this->composition->merge($next);

        $this->assertInstanceOf(Composition::class, $result);
        $this->assertCount(4, $result->getAtoms());
        $this->assertEquals(6, $result->getAtoms()['Fe']->getCount());
        $this->assertEquals(3, $result->getAtoms()['Mg']->getCount());
        $this->assertEquals(3, $result->getAtoms()['U']->getCount());
        $this->assertEquals(2, $result->getAtoms()['La']->getCount());
    }
}
