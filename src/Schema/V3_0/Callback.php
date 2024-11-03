<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0;

use DeadMansSwitch\OpenApi\Types\MapOfObjects;
use TypeError;

final class Callback extends MapOfObjects
{
    public static function getType(mixed $data): string
    {
        if (!is_array($data)) {
            throw new TypeError('Data must be an array');
        }

        if (array_key_exists('$ref', $data)) {
            return Reference::class;
        }

        return PathItem::class;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$value instanceof PathItem && !$value instanceof Reference) {
            throw new TypeError('Value must be an instance of PathItem or Reference');
        }

        parent::offsetSet($offset, $value);
    }

    public function offsetGet(mixed $offset): PathItem|Reference
    {
        return parent::offsetGet($offset);
    }
}