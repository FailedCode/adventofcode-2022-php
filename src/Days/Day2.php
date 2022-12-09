<?php

namespace Failedcode\Aoc2022\Days;

class Day2 extends AbstractDay
{
    public function solve_part_1(): string
    {
        $scoresPlay = [
            'X' => 1,
            'Y' => 2,
            'Z' => 3,
        ];
        $scoresOutcome = [
            'loss' => 0,
            'draw' => 3,
            'win' => 6,
        ];
        $outcomes = [
            "A X" => "draw",
            "B Y" => "draw",
            "C Z" => "draw",
            "A Y" => "win",
            "B Z" => "win",
            "C X" => "win",
            "A Z" => "loss",
            "B X" => "loss",
            "C Y" => "loss",
        ];

        $points = 0;
        $list = $this->util->loadInput(2);
        foreach ($list as $row) {
            if (empty($row)) {
                continue;
            }
            list($enemyMove, $myMove) = explode(' ', $row, 2);
            $outcome = $outcomes[$row];
            $points += $scoresOutcome[$outcome];
            $points += $scoresPlay[$myMove];

        }

        return $points;
    }

    public function solve_part_2(): string
    {
        $scoresPlay = [
            'A' => 1,
            'B' => 2,
            'C' => 3,
        ];
        $scoresOutcome = [
            'X' => 0,
            'Y' => 3,
            'Z' => 6,
        ];
        $moves = [
            "A X" => "C",
            "A Y" => "A",
            "A Z" => "B",
            "B X" => "A",
            "B Y" => "B",
            "B Z" => "C",
            "C X" => "B",
            "C Y" => "C",
            "C Z" => "A",
        ];

        $points = 0;
        $list = $this->util->loadInput(2);
        foreach ($list as $row) {
            if (empty($row)) {
                continue;
            }
            list($enemyMove, $outcome) = explode(' ', $row, 2);
            $myMove = $moves[$row];
            $points += $scoresOutcome[$outcome];
            $points += $scoresPlay[$myMove];

        }

        return $points;
    }
}
