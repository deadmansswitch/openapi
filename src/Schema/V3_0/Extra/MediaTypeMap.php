<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0\Extra;

use InvalidArgumentException;
use DeadMansSwitch\OpenAPI\Schema\V3_0\MediaType;
use DeadMansSwitch\OpenAPI\Types\MapOfObjects;

final class MediaTypeMap extends MapOfObjects
{
    static function getType(mixed $data): string
    {
        return MediaType::class;
    }

    public function offsetGet(mixed $offset): MediaType
    {
        return parent::offsetGet($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$value instanceof MediaType) {
            throw new InvalidArgumentException('Value must be an instance of MediaType');
        }

        parent::offsetSet($offset, $value);
    }
}