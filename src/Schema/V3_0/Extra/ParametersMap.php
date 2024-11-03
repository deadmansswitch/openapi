<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0\Extra;

use DeadMansSwitch\OpenApi\Schema\V3_0\Parameter;
use DeadMansSwitch\OpenApi\Schema\V3_0\Reference;
use DeadMansSwitch\OpenApi\Types\MapOfObjects;
use TypeError;

final class ParametersMap extends MapOfObjects
{
    static function getType(mixed $data): string
    {
        if (!is_array($data)) {
            throw new TypeError('Data must be an array');
        }

        if (array_key_exists('$ref', $data)) {
            return Reference::class;
        }

        return Parameter::class;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$value instanceof Parameter && !$value instanceof Reference) {
            throw new \InvalidArgumentException('Value must be an instance of Parameter or Reference');
        }

        parent::offsetSet($offset, $value);
    }

    public function offsetGet(mixed $offset): Parameter|Reference
    {
        return parent::offsetGet($offset);
    }
}