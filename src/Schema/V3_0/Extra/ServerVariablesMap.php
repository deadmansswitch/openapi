<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0\Extra;

use InvalidArgumentException;
use DeadMansSwitch\OpenApi\Schema\V3_0\ServerVariable;
use DeadMansSwitch\OpenApi\Types\MapOfObjects;

final class ServerVariablesMap extends MapOfObjects
{
    static function getType(mixed $data): string
    {
        return ServerVariable::class;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!is_a($value, ServerVariable::class)) {
            throw new InvalidArgumentException('Value must be instance of ' . ServerVariable::class);
        }

        parent::offsetSet($offset, $value);
    }

    public function offsetGet(mixed $offset): ServerVariable
    {
        return parent::offsetGet($offset);
    }
}