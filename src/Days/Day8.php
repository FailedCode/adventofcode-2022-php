<?php

namespace Failedcode\Aoc2022\Days;

class Day8 extends AbstractDay
{
    public function solve_part_1(): string
    {
        $trees = $this->getTreeGrid();
        $visibleTrees = $this->getEmptyGrid($trees);
        $height = count($trees);
        $width = count($trees[0]);
        for ($x = 0; $x < $width; $x += 1) {
            $visibleTrees[0][$x] = 1;
            $visibleTrees[$height - 1][$x] = 1;
        }
        for ($y = 0; $y < $height; $y += 1) {
            $visibleTrees[$y][0] = 1;
            $visibleTrees[$y][$width - 1] = 1;
        }

        // top->bottom
        for ($x = 1; $x < $width - 1; $x += 1) {
            $lastTree = $trees[0][$x];
            for ($y = 1; $y < $height; $y += 1) {
                if ($trees[$y][$x] > $lastTree) {
                    $visibleTrees[$y][$x] = 1;
                    $lastTree = max($lastTree, $trees[$y][$x]);
                }
                if ($lastTree > 8) {
                    break;
                }
            }
        }

        // bottom->top
        for ($x = 1; $x < $width - 1; $x += 1) {
            $lastTree = $trees[$height - 1][$x];
            for ($y = $height - 2; $y > 0; $y -= 1) {
                if ($trees[$y][$x] > $lastTree) {
                    $visibleTrees[$y][$x] = 1;
                    $lastTree = max($lastTree, $trees[$y][$x]);
                }
                if ($lastTree > 8) {
                    break;
                }
            }
        }

        // left->right
        for ($y = 1; $y < $height - 1; $y += 1) {
            $lastTree = $trees[$y][0];
            for ($x = 1; $x < $width - 1; $x += 1) {
                if ($trees[$y][$x] > $lastTree) {
                    $visibleTrees[$y][$x] = 1;
                    $lastTree = max($lastTree, $trees[$y][$x]);
                }
                if ($lastTree > 8) {
                    break;
                }
            }
        }

        // right->left
        for ($y = 1; $y < $height - 1; $y += 1) {
            $lastTree = $trees[$y][$width - 1];
            for ($x = $width - 2; $x > 0; $x -= 1) {
                if ($trees[$y][$x] > $lastTree) {
                    $visibleTrees[$y][$x] = 1;
                    $lastTree = max($lastTree, $trees[$y][$x]);
                }
                if ($lastTree > 8) {
                    break;
                }
            }
        }

        return array_reduce($visibleTrees, function ($carry, $row) {
            return $carry + array_reduce($row, function ($c, $v) {
                    return $c + (int)$v;
                });
        });
    }

    public function solve_part_2(): string
    {
        return "TODO";
    }

    protected function getTreeGrid()
    {
        $grid = [];
        $inputList = $this->util->loadInput(8);
        foreach ($inputList as $row) {
            if (empty($row)) {
                continue;
            }
            $grid[] = array_map(function ($v) {
                return (int)$v;
            }, str_split(trim($row)));
        }
        return $grid;
    }

    protected function getEmptyGrid($grid)
    {
        $emptyGrid = [];
        foreach ($grid as $row) {
            $emptyGrid[] = array_fill(0, count($row), 0);
        }
        return $emptyGrid;
    }
}
