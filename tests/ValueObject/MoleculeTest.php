<?php

namespace App\Tests\ValueObject;

use App\ValueObject\Molecule;
use PHPUnit\Framework\TestCase;

class MoleculeTest extends TestCase
{
    public function testGetExpression(): void
    {
        $molecule = new Molecule('H2O');

        $this->assertEquals('H2O', $molecule->getExpression());
    }
}
