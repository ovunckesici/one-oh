<?php

namespace Doranetyazilim\OneOh;

use Doranetyazilim\OneOh\Contracts\Option;

class OneOh
{
    protected array $options = [];

    protected array $configs = [];

    public function __construct(array $config)
    {
        $this->configs = $config;
    }

    protected function options(string $name): array
    {
        if (!isset($this->configs['options'][$name])) {
            throw new \InvalidArgumentException("{$name} not available.");
        }

        return $this->configs['options'][$name];
    }

    public function make(string $key, ?string $numbers = null): self
    {
        $options = $this->options($key);

        $this->options = $this->get($options);

        if ($numbers) {
            $this->parse($numbers);
        }

        return $this;
    }

    protected function get(array $options): array
    {
        return array_map(function ($item) {
            if (class_exists($item)) {
                $class = new $item;

                if (!$class instanceof Option) {
                    throw new \InvalidArgumentException("{$item} not an option.");
                }

                return new OneOhOption($class->name());
            }

            return new OneOhOption($item);
        }, $options);
    }

    protected function filter(string $key): array
    {
        $option = array_filter($this->options, function (OneOhOption $option) use ($key) {
            return $option->name() === $key;
        });

        if (!$option) {
            throw new \InvalidArgumentException("{$key} not an option.");
        }

        return $option;
    }


    public function first(string $key): ?OneOhOption
    {
        $option = $this->filter($key);

        if (!$option) {
            return null;
        }

        return $option[0];
    }

    public function all(): array
    {
        return array_map(function (OneOhOption $item) {
            return $item->toArray();
        }, $this->options);
    }

    public function parse(string $numbers, ?string $key = null): self
    {
        if ($key) {
            $this->make($key, $numbers);
        } else {

            $numbers = str_split($numbers);

            foreach ($numbers as $key => $number) {
                if (isset($this->options[$key])) {
                    $this->options[$key]->changeValue((int) $number);
                }
            }
        }

        return $this;
    }
}
