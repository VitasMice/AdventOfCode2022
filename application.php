#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use VitasMice\AoC22\Command\Day;

$application = new Application();

$application->add(new Day());

$application->run();