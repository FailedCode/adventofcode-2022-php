<?php

namespace Failedcode\Aoc2022\Days;

class Day10 extends AbstractDay
{
    public function solve_part_1(): string
    {
        $changes = $this->getRegisterChanges();
        $cycleSave = [
            20 => 0,
            60 => 0,
            100 => 0,
            140 => 0,
            180 => 0,
            220 => 0,
        ];
        $x = $cycle = 1;
        foreach ($changes as $change) {
            if (array_key_exists($cycle, $cycleSave)) {
                $cycleSave[$cycle] = $x * $cycle;
            }
            $x += $change;
            $cycle += 1;
        }
        return array_reduce($cycleSave, function($c, $v){ return $c + $v; });
    }

    public function solve_part_2(): string
    {
        return "TODO";
    }

    protected function getRegisterChanges()
    {
        $register = [];
        $inputList = array_filter($this->util->loadInput(10), 'strlen');
        foreach ($inputList as $row) {
            if (trim($row) === 'noop') {
                $register[] = 0;
                continue;
            }
            if (preg_match('~addx (-?\d+)~', $row, $match)) {
                $register[] = 0;
                $register[] = (int)$match[1];
            }
        }
        return $register;
    }
}
