<?php

namespace App\Tests\Parser;

use App\Parser\ExpressionParser;
use App\ValueObject\Atom;
use App\ValueObject\Composition;
use PHPUnit\Framework\TestCase;

class ExpressionParserTest extends TestCase
{
    /**
     * @dataProvider getExpressionProvider
     */
    public function testParse(string $expression, Composition $expected): void
    {
        $parser = new ExpressionParser();

        $this->assertEquals($expected, $parser->parse($expression));
    }

    /**
     * @dataProvider getErrorExpressionProvider
     * @expectedException \InvalidArgumentException
     */
    public function testParseWithError(string $expression): void
    {
        $parser = new ExpressionParser();

        $parser->parse($expression);
    }

    public function getExpressionProvider(): array
    {
        return [
            ['Fe', (new Composition())->addAtom(new Atom('Fe'))],
            ['FeMg', (new Composition())->addAtom(new Atom('Fe'))->addAtom(new Atom('Mg'))],
            ['H2O', (new Composition())->addAtom(new Atom('H', 2))->addAtom(new Atom('O'))],
            ['HHH', (new Composition())->addAtom(new Atom('H', 3))],
            ['H19', (new Composition())->addAtom(new Atom('H', 19))],
            ['H199', (new Composition())->addAtom(new Atom('H', 199))],
            ['H321', (new Composition())->addAtom(new Atom('H', 321))],
            ['OH', (new Composition())->addAtom(new Atom('O'))->addAtom(new Atom('H'))],
            ['(OH)', (new Composition())->addAtom(new Atom('O'))->addAtom(new Atom('H'))],
            ['(OH)2', (new Composition())->addAtom(new Atom('O', 2))->addAtom(new Atom('H', 2))],
            ['Mg(OH)2', (new Composition())->addAtom(new Atom('Mg'))->addAtom(new Atom('O', 2))->addAtom(new Atom('H', 2))],
            ['Mg(OH)2Fe', (new Composition())->addAtom(new Atom('Mg'))->addAtom(new Atom('O', 2))->addAtom(new Atom('H', 2))->addAtom(new Atom('Fe'))],
            ['Mg(OH)2Fe3', (new Composition())->addAtom(new Atom('Mg'))->addAtom(new Atom('O', 2))->addAtom(new Atom('H', 2))->addAtom(new Atom('Fe', 3))],
            ['K4[ON(SO3)2]2', (new Composition())->addAtom(new Atom('K', 4))->addAtom(new Atom('O', 14))->addAtom(new Atom('N', 2))->addAtom(new Atom('S', 4))],
            ['K4{ON{SO3}2}2', (new Composition())->addAtom(new Atom('K', 4))->addAtom(new Atom('O', 14))->addAtom(new Atom('N', 2))->addAtom(new Atom('S', 4))],
            ['K4[ON(SO3}2}2', (new Composition())->addAtom(new Atom('K', 4))->addAtom(new Atom('O', 14))->addAtom(new Atom('N', 2))->addAtom(new Atom('S', 4))],
            ['K4{ON{SO3}2(FeCa20)2}2', (new Composition())->addAtom(new Atom('K', 4))->addAtom(new Atom('O', 14))->addAtom(new Atom('N', 2))->addAtom(new Atom('S', 4))->addAtom(new Atom('Fe', 4))->addAtom(new Atom('Ca', 80))],
            ['H2(H2(H2(H2(H2(H2(H2(H2(H2(H2)))))))))2', (new Composition())->addAtom(new Atom('H', 38))],
        ];
    }

    public function getErrorExpressionProvider(): array
    {
        return [
            ['foo'],
            ['Fer'],
            ['Mg(OH)2foo'],
        ];
    }
}
