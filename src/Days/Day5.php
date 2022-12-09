<?php

namespace Failedcode\Aoc2022\Days;

class Day5 extends AbstractDay
{
    public function solve_part_1(): string
    {
        list($stacks, $commands) = $this->getInput();
        foreach ($commands as $command) {
            list($move, $fromStack, $toStack) = $command;
            for ($i = 0; $i < $move; $i += 1) {
                $stacks[$toStack][] = array_pop($stacks[$fromStack]);
            }
        }
        return $this->getTopStack($stacks);
    }

    public function solve_part_2(): string
    {
        list($stacks, $commands) = $this->getInput();
        foreach ($commands as $command) {
            list($move, $fromStack, $toStack) = $command;
            $crates = array_slice($stacks[$fromStack], -$move);
            foreach ($crates as $crate) {
                array_pop($stacks[$fromStack]);
                $stacks[$toStack][] = $crate;
            }
        }
        return $this->getTopStack($stacks);
    }

    protected function getTopStack($stacks)
    {
        $result = "";
        foreach ($stacks as $stack) {
            $result .= $stack[count($stack)-1];
        }
        return $result;
    }

    protected function getInput()
    {
        $inputList = $this->util->loadInput(5);
        $stacks = [];
        $commands = [];
        $firstEmptyRow = false;
        $i = 0;
        foreach ($inputList as $row) {
            if ($firstEmptyRow === false && empty($row)) {
                $firstEmptyRow = $i;
            }
            if (preg_match('~move (\d+) from (\d+) to (\d+)~', $row, $matches)) {
                $commands[] = [
                    $matches[1],
                    $matches[2]-1,
                    $matches[3]-1,
                ];
            }
            $i += 1;
        }

        for ($i = $firstEmptyRow-2; $i >= 0; $i -= 1) {
            $row = $inputList[$i];
            $slice = str_split($row, 4);
            $stackNr = 0;
            foreach ($slice as &$el) {
                $el = trim(str_replace(['[', ']'], '', $el));
                if (!empty($el)) {
                    $stacks[$stackNr][] = $el;
                }
                $stackNr += 1;
            }
        }

        return [$stacks, $commands];
    }
}
