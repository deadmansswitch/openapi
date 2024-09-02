<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Types\MapOfObjects;

final class Responses extends MapOfObjects
{
    static function getType(mixed $data): string
    {
        if (!is_array($data)) {
            throw new \InvalidArgumentException('Data must be an array');
        }

        if (array_key_exists('$ref', $data)) {
            return Reference::class;
        }

        return Response::class;
    }

    public function offsetGet(mixed $offset): Response|Reference
    {
        return $this->items[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$value instanceof Response && !$value instanceof Reference) {
            throw new \InvalidArgumentException('Value must be an instance of ' . Response::class . ' or ' . Reference::class);
        }

        $this->items[$offset] = $value;
    }
}