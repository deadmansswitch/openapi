<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0\Extra;

use DeadMansSwitch\OpenApi\Schema\V3_0\Link;
use DeadMansSwitch\OpenApi\Schema\V3_0\Reference;
use DeadMansSwitch\OpenApi\Types\MapOfObjects;
use TypeError;

final class LinksMap extends MapOfObjects
{
    static function getType(mixed $data): string
    {
        if (!is_array($data)) {
            throw new TypeError('Data must be an array');
        }

        if (array_key_exists('$ref', $data)) {
            return Reference::class;
        }

        return Link::class;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$value instanceof Link && !$value instanceof Reference) {
            throw new TypeError('Value must be an instance of Header or Reference');
        }

        parent::offsetSet($offset, $value);
    }

    public function offsetGet(mixed $offset): Link|Reference
    {
        return parent::offsetGet($offset);
    }
}