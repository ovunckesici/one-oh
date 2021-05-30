<?php

namespace Doranetyazilim\OneOh;

class OneOhOption
{
    protected string $name = '';

    protected int $value = 0;

    protected bool $status = false;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function changeValue(int $value): void
    {
        $this->value = $value;
        $this->status = (bool) $value;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
            'status' => $this->status,
        ];
    }
}
