<?php

namespace Failedcode\Aoc2022\Days;

class Day7 extends AbstractDay
{
    public function solve_part_1(): string
    {
        $dirSizes = $this->getDirSizes();
        $totalSize = 0;
        $maxSize = 100000;
        foreach ($dirSizes as $dir => $size) {
            if ($size <= $maxSize) {
                $totalSize += $size;
            }
        }
        return $totalSize;
    }

    public function solve_part_2(): string
    {
        $dirSizes = $this->getDirSizes();
        $totalSize = $smallestDirSize = 70000000;
        $neededFreeSize = 30000000;
        $currentUsedSize = $dirSizes['/'];
        foreach ($dirSizes as $dir => $size) {
            if ($totalSize - $currentUsedSize + $size >= $neededFreeSize) {
                if ($size < $smallestDirSize) {
                    $smallestDirSize = $size;
                }
            }
        }
        return $smallestDirSize;
    }

    protected function getDirSizes()
    {
        $filesystem = $this->getFilesystem();
        $dirSizes = [];
        foreach ($filesystem as $path => $size) {
            if (str_ends_with($path, '/')) {
                continue;
            }

            while (true) {
                $path = dirname($path);
                if (!isset($dirSizes[$path])) {
                    $dirSizes[$path] = 0;
                }
                $dirSizes[$path] += $size;
                if ($path === '/') {
                    break;
                }
            }
        }
        return $dirSizes;
    }

    protected function getFilesystem()
    {
        $sep = '/';
        $currentDir = $sep;
        $filesystem[$currentDir] = [];
        $inputList = $this->util->loadInput(7);
        foreach ($inputList as $row) {
            if (preg_match('~\$ cd (\S+)~', $row, $match)) {
                $dir = trim($match[1]);
                if ($dir === '..') {
                    $currentDir = $this->backOneDir($currentDir, $sep);
                    continue;
                }
                if ($dir === '/') {
                    $currentDir = $sep;
                    continue;
                }
                $currentDir .= "{$dir}$sep";
                if (!isset($filesystem[$currentDir])) {
                    $filesystem[$currentDir] = [];
                }
                continue;
            }
            if ($row === '$ ls') {
                continue;
            }
            if (preg_match('~dir (\S+)~', $row, $match)) {
                $dir = $currentDir . "{$match[1]}$sep";
                if (!isset($filesystem[$dir])) {
                    $filesystem[$dir] = [];
                }
                continue;
            }
            if (preg_match('~(\d+) (\S+)~', $row, $match)) {
                $file = $currentDir . "{$match[2]}";
                $filesystem[$file] = (int)$match[1];
            }
        }
        return $filesystem;
    }

    protected function backOneDir($dir, $sep)
    {
        $parts = explode($sep, $dir);
        array_pop($parts);
        array_pop($parts);
        return implode($sep, $parts) . $sep;
    }
}
