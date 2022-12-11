<?php

namespace Failedcode\Aoc2022\Days;

use Failedcode\Aoc2022\Days\Support\Monkey;

class Day11 extends AbstractDay
{
    public function solve_part_1(): string
    {
        $monkeys = $this->loadMonkeys();
        $rounds = 20;
        for ($i = 0; $i < $rounds; $i += 1) {
            /** @var Monkey $monkey */
            foreach ($monkeys as $monkey) {
                $monkey->calculateTurn($monkeys);
            }
        }
        uasort($monkeys, function ($a, $b) {
            return $a->getInspections() - $b->getInspections();
        });

        $monkeyFirst = array_pop($monkeys);
        $monkeySecond = array_pop($monkeys);
        return $monkeyFirst->getInspections() * $monkeySecond->getInspections();
    }

    public function solve_part_2(): string
    {
        return "TODO";
    }

    protected function loadMonkeys()
    {
        $inputList = $this->util->loadInput(11);
        $monkeyList = [];
        $monkeyData = [];
        foreach ($inputList as $row) {
            if (empty(trim($row))) {
                $monkeyList[$monkeyData['nr']] = new Monkey($monkeyData);
                $monkeyData = [];
            }
            if (preg_match('~Monkey (\d+):~', $row, $match)) {
                $monkeyData['nr'] = (int)$match[1];
            }
            if (preg_match('~Starting items:(.+)~', $row, $match)) {
                $monkeyData['items'] = array_map(function ($el) {
                    return (int)$el;
                }, explode(',', $match[1]));
            }
            if (preg_match('~Operation: new = old ([+*]) (\d+|old)~', $row, $match)) {
                $monkeyData['operationType'] = $match[1];
                if ($match[2] === 'old') {
                    $monkeyData['oldValue'] = true;
                } else {
                    $monkeyData['operationValue'] = (int)$match[2];
                }
            }
            if (preg_match('~Test: divisible by (\d+)~', $row, $match)) {
                $monkeyData['divisionTestValue'] = (int)$match[1];
            }
            if (preg_match('~If (true|false): throw to monkey (\d+)~', $row, $match)) {
                $monkeyData["if-{$match[1]}"] = (int)$match[2];
            }
        }
        return $monkeyList;
    }
}
