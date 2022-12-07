<?php
require 'vendor/autoload.php';

$day = 0;
foreach ($argv as $argument) {
    if (preg_match('~--day=(\d+)~', $argument, $match)) {
        $day = (int)$match[1];
    }
}
if ($day === 0) {
    $day = (int)strftime('%d');
}

$solverClass = "\Failedcode\Aoc2022\Days\Day{$day}";
/** @var \Failedcode\Aoc2022\Days\AbstractDay $solver */
if (!class_exists($solverClass)) {
    echo "Day {$day} not yet implemented!\n";
    exit(0);
}
$solver = new $solverClass;
echo "Day {$day}\n";
echo "Part 1: {$solver->solve_part_1()}\n";
echo "Part 2: {$solver->solve_part_2()}\n";

echo "\n";
