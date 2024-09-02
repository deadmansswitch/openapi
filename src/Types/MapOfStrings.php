<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Types;

use ArrayAccess;
use ArrayIterator;
use InvalidArgumentException;
use IteratorAggregate;
use Traversable;

class MapOfStrings implements IteratorAggregate, ArrayAccess
{
    private array $items = [];

    public static function fromArray(array $items): self
    {
        $map = new self();

        foreach ($items as $key => $value) {
            $map->offsetSet($key, $value);
        }

        return $map;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->items);
    }

    public function offsetGet(mixed $offset): string
    {
        return $this->items[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('$value must be a string');
        }

        $this->items[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }
}