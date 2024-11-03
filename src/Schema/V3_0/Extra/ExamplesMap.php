<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0\Extra;

use InvalidArgumentException;
use DeadMansSwitch\OpenApi\Schema\V3_0\Example;
use DeadMansSwitch\OpenApi\Schema\V3_0\Reference;
use DeadMansSwitch\OpenApi\Types\MapOfObjects;
use TypeError;

final class ExamplesMap extends MapOfObjects
{
    static function getType(mixed $data): string
    {
        if (!is_array($data)) {
            throw new TypeError('Data must be an array');
        }

        if (array_key_exists('$ref', $data)) {
            return Reference::class;
        }

        return Example::class;
    }

    public function offsetGet(mixed $offset): Example|Reference
    {
        return parent::offsetGet($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$value instanceof Example && !$value instanceof Reference) {
            throw new InvalidArgumentException('Value must be an instance of Example or Reference');
        }

        parent::offsetSet($offset, $value);
    }
}