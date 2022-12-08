<?php

namespace Failedcode\Aoc2022\Days;

class Day1 extends AbstractDay
{

    public function solve_part_1(): string
    {
        $calories = $this->getCalories();
        return max($calories);
    }

    public function solve_part_2(): string
    {
        $calories = $this->getCalories();
        $caloriesMax = 0;
        for ($i = 0; $i < 3; $i += 1) {
            $maxVal = max($calories);
            $position = array_search($maxVal, $calories);
            unset($calories[$position]);
            $caloriesMax += (int)$maxVal;
        }
        return $caloriesMax;
    }

    public function getCalories(): array
    {
        $list = $this->util->loadInput(1);
        $calories = [];
        $currentSum = 0;
        foreach ($list as $row) {
            if (trim($row) === '') {
                $calories[] = $currentSum;
                $currentSum = 0;
                continue;
            }
            $currentSum += (int)$row;
        }
        return $calories;
    }
}
