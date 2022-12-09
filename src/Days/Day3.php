<?php

namespace Failedcode\Aoc2022\Days;

class Day3 extends AbstractDay
{
    public function solve_part_1(): string
    {
        $inputList = $this->util->loadInput(3);
        $prioritySum = 0;
        foreach ($inputList as $row) {
            if (empty($row)) {
                continue;
            }
            $len = strlen($row)/2;
            $left = $this->charMap(substr($row, 0, $len));
            $right = str_split(substr($row, $len));
            foreach ($right as $char) {
                if (isset($left[$char])) {
                    $prioritySum += $this->charValue($char);
                    break;
                }
            }
        }
        return $prioritySum;
    }

    public function solve_part_2(): string
    {
        $inputList = $this->util->loadInput(3);
        $chunkedList = $this->chunkArray($inputList, 3);
        $prioritySum = 0;
        foreach ($chunkedList as $team) {
            $charMap = [];
            foreach ($team as $row) {
                $chars = array_unique(str_split($row));
                foreach ($chars as $char) {
                    if (!isset($charMap[$char])) {
                        $charMap[$char] = 0;
                    }
                    $charMap[$char] += 1;
                    if ($charMap[$char] === 3) {
                        $prioritySum += $this->charValue($char);
                        break 2;
                    }
                }
            }
        }
        return $prioritySum;
    }

    protected function chunkArray($array, $chunkSize)
    {
        $result = [];
        $currentChunk = [];
        foreach ($array as $element) {
            $currentChunk[] = $element;
            if (count($currentChunk) === $chunkSize) {
                $result[] = $currentChunk;
                $currentChunk = [];
            }
        }
        return $result;
    }

    protected function charMap($string)
    {
        $chars = str_split($string);
        $charMap = [];
        foreach ($chars as $char) {
            $charMap[$char] = 0;
        }
        return $charMap;
    }

    protected function charValue($char)
    {
        if ($char === strtolower($char)) {
            return ord($char) - ord('a') + 1;
        }
        return ord($char) - ord('A') + 1 + 26;
    }
}
