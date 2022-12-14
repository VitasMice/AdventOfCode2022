<?php

declare(strict_types=1);

namespace VitasMice\AoC22\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VitasMice\AoC22\Solutions\DayInterface;

#[AsCommand(name: 'run:day')]
class Day extends Command
{
    private string $dayClass;

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('day', InputArgument::REQUIRED, 'Advent of Code day number to solve');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dayNumber = (int) $input->getArgument('day');
        $dayClassName = sprintf('VitasMice\\AoC22\\Solutions\\Day%d', $dayNumber);

        if (false === class_exists($dayClassName)) {
            $output->writeln(
                sprintf('Solution class for day %s does not exist.', $dayNumber)
            );

            return Command::FAILURE;
        }

        /* @var DayInterface $daySolution */
        $daySolution = new $dayClassName($dayNumber);

        $daySolution->solve();

        $output->writeln('First part solution - ' . $daySolution->getFirstPartSolution());
        $output->writeln('Second part solution - ' . $daySolution->getSecondPartSolution());

        return Command::SUCCESS;
    }
}
