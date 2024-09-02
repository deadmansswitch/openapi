<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Schema\V3_0;

use ArrayAccess;
use ArrayIterator;
use InvalidArgumentException;
use IteratorAggregate;
use Traversable;

final class SpecificationExtensions implements IteratorAggregate, ArrayAccess
{
    private array $items = [];

    public static function fromArray(array $items): self
    {
        $instance = new self();

        foreach ($items as $key => $value) {
            $instance->offsetSet($key, $value);
        }

        return $instance;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
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
        if (!str_starts_with($offset, 'x-')) {
            throw new InvalidArgumentException('Specification extensions key must start with "^x-".');
        }

        $this->items[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }
}