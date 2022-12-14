<?php

namespace Failedcode\Aoc2022\Days;

class Day9 extends AbstractDay
{
    public function solve_part_1(): string
    {
        $moves = $this->getMoves();
        $headX = $headY = 0;
        $tailX = $tailY = 0;
        $tailPositions = [];
        $tailPositions["{$tailX}|{$tailY}"] = true;
        foreach ($moves as $move) {
            list($x, $y) = $move;
            $headX += $x;
            $headY += $y;

            if (!$this->inRange($headX, $headY, $tailX, $tailY)) {
                $xdiff = $headX - $tailX;
                $ydiff = $headY - $tailY;
                if ($headX != $tailX && $headY != $tailY) {
                    // diagonal
                    $tailX += $this->sign($xdiff);
                    $tailY += $this->sign($ydiff);
                } elseif (abs($xdiff) > abs($ydiff)) {
                    $tailX += $this->sign($xdiff);
                } elseif (abs($ydiff) > abs($xdiff)) {
                    $tailY += $this->sign($ydiff);
                }
                $tailPositions["{$tailX}|{$tailY}"] = true;
            }
        }

        return count($tailPositions);
    }

    public function solve_part_2(): string
    {
        $X = 0;
        $Y = 1;
        $moves = $this->getMoves();
        $knotCount = 10;
        $knots = $this->fillArray($knotCount);
        $tailPositions = [];
        $tailPositions["0|0"] = true;
        foreach ($moves as $move) {
            list($x, $y) = $move;

            $knots[0][$X] += $x;
            $knots[0][$Y] += $y;
            for ($i = 1; $i < $knotCount; $i += 1) {
                if ($this->inRange($knots[$i-1][$X], $knots[$i-1][$Y], $knots[$i][$X], $knots[$i][$Y])) {
                    break;
                } else {
                    $xdiff = $knots[$i-1][$X] - $knots[$i][$X];
                    $ydiff = $knots[$i-1][$Y] - $knots[$i][$Y];
                    if ($knots[$i-1][$X] != $knots[$i][$X] && $knots[$i-1][$Y] != $knots[$i][$Y]) {
                        // diagonal
                        $knots[$i][$X] += $this->sign($xdiff);
                        $knots[$i][$Y] += $this->sign($ydiff);
                    } elseif (abs($xdiff) > abs($ydiff)) {
                        $knots[$i][$X] += $this->sign($xdiff);
                    } elseif (abs($ydiff) > abs($xdiff)) {
                        $knots[$i][$Y] += $this->sign($ydiff);
                    }
                    if ($i === $knotCount-1) {
                        $tailPositions["{$knots[$i][$X]}|{$knots[$i][$Y]}"] = true;
                    }
                }
            }

        }
        return count($tailPositions);
    }

    protected function sign($n)
    {
        if ($n > 0) {
            return 1;
        }
        if ($n < 0) {
            return -1;
        }
        return 0;
    }

    protected function fillArray($n)
    {
        $result = [];
        for ($i = 0; $i < $n; $i += 1) {
            $result[] = [0, 0];
        }
        return $result;
    }

    protected function inRange($x1, $y1, $x2, $y2)
    {
        return abs($x1 - $x2) < 2 && abs($y1 - $y2) < 2;
    }

    protected function getMoves()
    {
        $moves = [];
        $inputList = $this->util->loadInput(9);
        foreach ($inputList as $row) {
            if (empty($row)) {
                continue;
            }
            list($dir, $n) = explode(' ', trim($row), 2);
            for ($i = 0; $i < (int)$n; $i += 1) {
                switch ($dir) {
                    case 'R': $moves[] = [1, 0]; break;
                    case 'L': $moves[] = [-1, 0]; break;
                    case 'D': $moves[] = [0, 1]; break;
                    case 'U': $moves[] = [0, -1]; break;
                }
            }
        }
        return $moves;
    }
}
