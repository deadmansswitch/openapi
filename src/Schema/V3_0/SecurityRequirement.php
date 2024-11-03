<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use Traversable;

final class SecurityRequirement implements IteratorAggregate, ArrayAccess
{
    /**
     * @var array<array-key, array<array-key, string>>
     */
    private array $items = [];

    public static function fromArray(array $items): self
    {
        $sr = new self();

        foreach ($items as $key => $val) {
            $sr->offsetSet($key, $val);
        }

        return $sr;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->items);
    }

    public function offsetGet(mixed $offset): array
    {
        return $this->items[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->items[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }
}