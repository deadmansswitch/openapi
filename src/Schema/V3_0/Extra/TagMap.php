<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0\Extra;

use InvalidArgumentException;
use DeadMansSwitch\OpenApi\Schema\V3_0\Tag;
use DeadMansSwitch\OpenApi\Types\MapOfObjects;

final class TagMap extends MapOfObjects
{
    static function getType(mixed $data): string
    {
        return Tag::class;
    }

    public function offsetGet(mixed $offset): Tag
    {
        return parent::offsetGet($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$value instanceof Tag) {
            throw new InvalidArgumentException('Value must be an instance of Tag');
        }

        parent::offsetSet($offset, $value);
    }
}