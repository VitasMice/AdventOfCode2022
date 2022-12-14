<?php

namespace VitasMice\AoC22\Solutions;

interface DayInterface
{

    public function __construct(int $dayNumber);

    public function solve(): void;
    
    public function getFirstPartSolution(): string;

    public function getSecondPartSolution(): string;

    public function setFirstPartSolution(string $firstPartSolution): self;

    public function setSecondPartSolution(string $firstPartSolution): self;
}