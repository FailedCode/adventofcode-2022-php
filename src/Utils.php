<?php

namespace Failedcode\Aoc2022;

class Utils
{
    protected array $env = [];

    /**
     * @param int $day
     * @param string $type
     * @return array
     * @throws \Exception
     */
    public function loadInput($day, $type = "day"): array
    {
        $filePath = "input/{$type}{$day}.txt";
        if (!file_exists($filePath)) {
            if ($this->downloadInput($day, $filePath) === false) {
                throw new \Exception("Input missing: '$filePath'", 1670457206416);
            }
        }
        $content = file_get_contents($filePath);
        return explode("\n", $content);
    }

    /**
     * @param int $day
     * @param string $filePath
     * @return bool
     * @throws \Exception
     */
    protected function downloadInput($day, $filePath): bool
    {
        if (empty($this->env)) {
            $this->loadDotEnv();
        }
        if (!isset($this->env["SESSION"])) {
            return false;
        }

        $curl = \curl_init();
        $options = [
            CURLOPT_URL => "https://adventofcode.com/2022/day/$day/input",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_COOKIE => "session=" . $this->env["SESSION"],
            CURLOPT_USERAGENT => "https://github.com/FailedCode/adventofcode-2022-php by xeres666@googlemail.com",
        ];
        \curl_setopt_array($curl, $options);
        $result = \curl_exec($curl);
        $err = \curl_errno($curl);
        $errmsg = \curl_error($curl);
        \curl_close($curl);

        if ($err) {
            throw new \Exception("Error downloading input for day {$day}:\n{$errmsg}\n", 1670546029246);
        }
        return file_put_contents($filePath, $result) !== false;
    }

    /**
     * @return void
     */
    protected function loadDotEnv()
    {
        $envFile = __dir__ . '/../.env';
        if (!file_exists($envFile)) {
            return;
        }
        $lines = array_filter(explode("\n", file_get_contents($envFile)), 'strlen');
        foreach ($lines as $line) {
            // skip comments
            if (preg_match('~^\s*#~', $line)) {
                continue;
            }
            if (strpos($line, '=') !== false) {
                list($var, $value) = explode('=', $line, 2);
                $var = strtoupper(trim($var));
                if (strlen($var) > 1) {
                    $this->env[$var] = $value;
                }
            }
        }
    }

    /**
     * @param int $day
     * @return void
     */
    public function createDayFromTemplate($day)
    {
        $templateFile = __dir__ . '/Days/DayTemplate.php';
        $classReplace = "Day{$day}";
        $classFind = basename($templateFile, '.php');
        $destinationFilepath = dirname($templateFile) . "/$classReplace.php";

        if (file_exists($destinationFilepath)) {
            return;
        }

        $content = file_get_contents($templateFile);
        $content = str_replace([$classFind, '$DAY'], [$classReplace, $day], $content);
        file_put_contents($destinationFilepath, $content);
    }
}
