<?php

declare(strict_types=1);

namespace VitasMice\AoC22\Solutions;

use Symfony\Component\Filesystem\Filesystem;

class Day8
{
    private array $inputPuzzle;
    private string $firstPartSolution;
    private string $secondPartSolution;

    public function __construct(
        private readonly int $dayNumber
    ) {
    }

    public function solve(): void
    {
        $this->inputPuzzle = $this->readInput();

        $this->solveFirstPart();
        $this->solveSecondPart();
    }

    public function getFirstPartSolution(): string
    {
        return $this->firstPartSolution;
    }

    private function setFirstPartSolution(string $firstPartSolution): self
    {
        $this->firstPartSolution = $firstPartSolution;

        return $this;
    }

    public function getSecondPartSolution(): string
    {
        return $this->secondPartSolution;
    }

    private function setSecondPartSolution(string $secondPartSolution): self
    {
        $this->secondPartSolution = $secondPartSolution;

        return $this;
    }

    private function solveFirstPart(): void {
        $visible = 0;

        foreach ($this->inputPuzzle as $rowIndex => $row) {
            foreach ($row as $colIndex => $tree) {
                if ($this->checkVisibility((int) $rowIndex, (int) $colIndex, (int) $tree)) {
                    $visible++;
                }
            }
        }

        $this->setFirstPartSolution((string) $visible);
    }

    private function solveSecondPart(): void {
        $score = 0;

        foreach ($this->inputPuzzle as $rowIndex => $row) {
            foreach ($row as $colIndex => $tree) {
                $ourScore = $this->getTreesScenicScore((int) $rowIndex, (int) $colIndex, (int) $tree);
                $score = max($score, $ourScore);
            }
        }

        $this->setSecondPartSolution((string) $score);
    }

    private function getTreesScenicScore(int $rowIndex, int $colIndex, int $height): int
    {
        $scores = [];
        $set = [
            $this->getUp($rowIndex, $colIndex),
            $this->getDown($rowIndex, $colIndex),
            $this->getLeft($rowIndex, $colIndex),
            $this->getRight($rowIndex, $colIndex),
        ];
        foreach ($set as $direction) {
            $score = 0;
            $direction = array_reverse($direction);
            foreach ($direction as $tree) {
                $score++;
                if ($tree >= $height) {
                    break;
                }
            }
            $scores[] = $score;
        }

        return array_product($scores);
    }

    private function checkVisibility(int $rowIndex, int $colIndex, int $height): bool
    {
        if ($rowIndex === 0 || $colIndex === 0) {
            return true;
        }
        if ($rowIndex === count($this->inputPuzzle) - 1 || $colIndex === count($this->inputPuzzle[0]) - 1) {
            return true;
        }

        $set = [
            $this->getUp($rowIndex, $colIndex),
            $this->getDown($rowIndex, $colIndex),
            $this->getLeft($rowIndex, $colIndex),
            $this->getRight($rowIndex, $colIndex),
        ];

        $hidden = 0;
        foreach ($set as $direction) {
            foreach ($direction as $tree) {
                if ($tree >= $height) {
                    $hidden++;
                    break;
                }
            }
        }

        return $hidden !== 4;
    }

    private function getUp(int $rowIndex, int $colIndex): array
    {
        $result = [];
        for($i = 0; $i < $rowIndex; $i++) {
            $result[] = $this->inputPuzzle[$i][$colIndex];
        }
        return $result;
    }

    private function getDown(int $rowIndex, int $colIndex): array
    {
        $result = [];
        for($i = count($this->inputPuzzle) - 1; $i > $rowIndex; $i--) {
            $result[] = $this->inputPuzzle[$i][$colIndex];
        }
        return $result;
    }

    private function getLeft(int $rowIndex, int $colIndex): array
    {
        return array_slice($this->inputPuzzle[$rowIndex], 0, $colIndex);
    }

    private function getRight(int $rowIndex, int $colIndex): array
    {
        $slice = array_slice($this->inputPuzzle[$rowIndex], $colIndex + 1);
        return array_reverse($slice);
    }

    private function readInput(): array
    {
        $inputFilename = $this->getInputFilename();

        $arrayLines = file($inputFilename, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

        return array_map(function($line) {
            return str_split($line);
        }, $arrayLines);
    }

    private function getInputFilename(): string
    {
        $fileSystem = new Filesystem();

        return sprintf('input/day%s.txt', $this->dayNumber);
    }
}
