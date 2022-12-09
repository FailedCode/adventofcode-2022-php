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
if ($day < 1 || $day > 25) {
    echo "Day {$day} not supported!\n";
    exit(0);
}

$solverClass = "\Failedcode\Aoc2022\Days\Day{$day}";
/** @var \Failedcode\Aoc2022\Days\AbstractDay $solver */
if (!class_exists($solverClass)) {
    $uitls = new \Failedcode\Aoc2022\Utils();
    $uitls->createDayFromTemplate($day);
    $uitls->loadInput($day);
    echo "Day {$day} not yet implemented!\n";
    exit(0);
}
$solver = new $solverClass;
echo "Day {$day}\n";
echo "Part 1: {$solver->solve_part_1()}\n";
echo "Part 2: {$solver->solve_part_2()}\n";

echo "\n";
