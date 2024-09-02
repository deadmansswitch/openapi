<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Types;

use ArrayAccess;
use ArrayIterator;
use InvalidArgumentException;
use IteratorAggregate;
use Traversable;

abstract class MapOfObjects implements IteratorAggregate, ArrayAccess
{
    protected array $items = [];

    abstract static function getType(mixed $data): string;

    public static function fromArray(array $items): static
    {
        $map = new static();

        foreach ($items as $key => $value) {
            $map[$key] = $value;
        }

        return $map;
    }

    public function getIterator(): Traversable
    {
        yield from $this->items;
    }

    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->items);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!is_object($value))  {
            throw new InvalidArgumentException('Value must be an object.');
        }

        $this->items[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }
}