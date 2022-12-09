<?php

namespace Failedcode\Aoc2022\Days;

class Day6 extends AbstractDay
{
    public function solve_part_1(): string
    {
        $input = $this->util->loadInput(6)[0];
        return $this->getSignalLengthPosition($input, 4);
    }

    public function solve_part_2(): string
    {
        $input = $this->util->loadInput(6)[0];
        return $this->getSignalLengthPosition($input, 14);
    }

    protected function getSignalLengthPosition($input, $signalLength)
    {
        for($i = 0; $i < $signalLength; $i += 1) {
            $signals[] = substr($input, $i, 1);
        }
        for($i = $signalLength; $i < strlen($input); $i += 1) {
            if (count(array_unique($signals)) === $signalLength) {
                return $i;
            }
            $signals[] = substr($input, $i, 1);
            array_shift($signals);
        }
        return "Error: no position found";
    }
}
