<?php

namespace Bootstrap;

use Exception;

class Container
{
    private array $bindings = [];

    public function set(string $id, callable $factory): void
    {
        $this->bindings[$id] = $factory;
    }

    /**
     * @throws Exception
     */
    public function get(string $id)
    {
        if (!isset($this->bindings[$id])) {
            throw new Exception("Target binding [$id] does not exist.");
        }

        $factory = $this->bindings[$id];

        return $factory($this);
    }
}