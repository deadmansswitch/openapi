<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0\Extra;

use InvalidArgumentException;
use DeadMansSwitch\OpenApi\Schema\V3_0\Encoding;
use DeadMansSwitch\OpenApi\Types\MapOfObjects;

final class EncodingMap extends MapOfObjects
{
    static function getType(mixed $data): string
    {
        return Encoding::class;
    }

    public function offsetGet(mixed $offset): Encoding
    {
        return parent::offsetGet($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$value instanceof Encoding) {
            throw new InvalidArgumentException('Value must be an instance of Encoding');
        }

        parent::offsetSet($offset, $value);
    }
}