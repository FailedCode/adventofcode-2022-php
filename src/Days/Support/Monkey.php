<?php

namespace Failedcode\Aoc2022\Days\Support;

class Monkey
{
    public const OP_ADD = '+';
    public const OP_MUL = '*';
    public const WORRY_DIV = 3;

    protected int $nr = 0;
    protected array $items = [];
    protected string $operationType = '';
    protected int $operationValue = 0;
    protected bool $operationUseOldValue = false;
    protected int $divisionTestValue = 0;
    protected int $ifTrueMonkey = 0;
    protected int $ifFalseMonkey = 0;
    protected int $inspections = 0;

    public function __construct(array $data)
    {
        $this->nr = $data['nr'];
        $this->items = $data['items'];
        $this->operationType = $data['operationType'];
        $this->operationValue = $data['operationValue'] ?? 0;
        $this->operationUseOldValue = $data['oldValue'] ?? false;
        $this->divisionTestValue = $data['divisionTestValue'];
        $this->ifTrueMonkey = $data['if-true'];
        $this->ifFalseMonkey = $data['if-false'];
    }

    public function printItems()
    {
        $items = implode(', ', $this->items);
        echo "Monkey {$this->nr}: $items\n";
    }

    public function printAll()
    {
        $this->printItems();
        $opVal = $this->operationUseOldValue ? 'old' : $this->operationValue;
        echo "\tOP: {$this->operationType} {$opVal} (test: {$this->divisionTestValue})\n";
        echo "\tTrue: {$this->ifTrueMonkey}; False: {$this->ifFalseMonkey}\n";
    }

    public function printInspections()
    {
        echo "Monkey {$this->nr}: {$this->inspections}\n";
    }

    public function calculateTurn($monkeyList)
    {
        $itemCount = count($this->items);
        for ($i = 0; $i < $itemCount; $i += 1) {
            $item = array_shift($this->items);
            $this->inspections += 1;
            $opVal = $this->operationUseOldValue ? $item : $this->operationValue;
            switch ($this->operationType) {
                case self::OP_ADD:
                    $item += $opVal;
                    break;
                case self::OP_MUL:
                    $item *= $opVal;
                    break;
                default:
                    echo "\nUNKNOWN OPERATOR '{$this->operationType}'\n";
                    exit(0);
            }
            $item = (int)($item / self::WORRY_DIV);
            if ($item % $this->divisionTestValue == 0) {
                $monkeyList[$this->ifTrueMonkey]->receiveItem($item);
            } else {
                $monkeyList[$this->ifFalseMonkey]->receiveItem($item);
            }
        }
    }

    public function receiveItem($item)
    {
        $this->items[] = $item;
    }

    public function getInspections(): int
    {
        return $this->inspections;
    }
}
