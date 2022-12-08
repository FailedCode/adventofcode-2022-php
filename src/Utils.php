<?php

namespace Failedcode\Aoc2022;

class Utils
{
    public function loadInput($day, $type="day"): array
    {
        $filePath = "input/{$type}{$day}.txt";
        if (!file_exists($filePath)) {
            // TODO: download input
            throw new \Exception("Input missing: '$filePath'", 1670457206416);
        }
        $content = file_get_contents($filePath);
        return explode("\n", $content);
    }
}
