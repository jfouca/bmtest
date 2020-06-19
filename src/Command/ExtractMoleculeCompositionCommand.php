<?php

namespace App\Command;

use App\Parser\ExpressionParser;
use App\ValueObject\Molecule;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExtractMoleculeCompositionCommand extends Command
{
    protected static $defaultName = 'bm:molecule:composition:extract';

    protected function configure()
    {
        $this
            ->setDescription('Return the Atom Composition of the given molecule formatted as string')
            ->addArgument('expression', InputArgument::REQUIRED, 'molecule expression')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $molecule = new Molecule($input->getArgument('expression'));
        $parser = new ExpressionParser();

        $output->writeln(json_encode($parser->parse($molecule->getExpression())));

        return 0;
    }
}
