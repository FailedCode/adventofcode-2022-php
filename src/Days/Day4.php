<?php

namespace Failedcode\Aoc2022\Days;

class Day4 extends AbstractDay
{
    public function solve_part_1(): string
    {
        $ranges = $this->getInputRanges();
        $containSum = 0;
        foreach ($ranges as $range) {
            list($r1s, $r1e, $r2s, $r2e) = $range;
            if (($r2s >= $r1s && $r2e <= $r1e) || ($r1s >= $r2s && $r1e <= $r2e)) {
                $containSum += 1;
            }
        }
        return $containSum;
    }

    public function solve_part_2(): string
    {
        $ranges = $this->getInputRanges();
        $containSum = 0;
        foreach ($ranges as $range) {
            list($r1s, $r1e, $r2s, $r2e) = $range;
            if ($this->isInRange($r1s, $r2s, $r2e) ||
                $this->isInRange($r1e, $r2s, $r2e) ||
                $this->isInRange($r2s, $r1s, $r1e) ||
                $this->isInRange($r2e, $r1s, $r1e)) {
                $containSum += 1;
            }
        }
        return $containSum;
    }

    protected function isInRange($x, $start, $end)
    {
        return $x >= $start && $x <= $end;
    }

    protected function getInputRanges()
    {
        $inputList = $this->util->loadInput(4);
        $ranges = [];
        foreach ($inputList as $row) {
            if (preg_match('~(\d+)-(\d+),(\d+)-(\d+)~', $row, $matches)) {
                $ranges[] = array_slice($matches, 1);
            }
        }
        return $ranges;
    }
}
