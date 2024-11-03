<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0\Extra;

use DeadMansSwitch\OpenApi\Schema\V3_0\Header;
use DeadMansSwitch\OpenApi\Schema\V3_0\Reference;
use DeadMansSwitch\OpenApi\Types\MapOfObjects;
use TypeError;

final class HeadersMap extends MapOfObjects
{
    static function getType(mixed $data): string
    {
        if (!is_array($data)) {
            throw new TypeError('Data must be an array');
        }

        if (array_key_exists('$ref', $data)) {
            return Reference::class;
        }

        return Header::class;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$value instanceof Header && !$value instanceof Reference) {
            throw new TypeError('Value must be an instance of Header or Reference');
        }

        parent::offsetSet($offset, $value);
    }

    public function offsetGet(mixed $offset): Header|Reference
    {
        return parent::offsetGet($offset);
    }
}