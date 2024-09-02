<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Schema\V3_0\Extra;

use InvalidArgumentException;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Server;
use DeadMansSwitch\OpenAPI\Types\MapOfObjects;

final class ServerMap extends MapOfObjects
{
    static function getType(mixed $data): string
    {
        return Server::class;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!is_a($value, Server::class)) {
            throw new InvalidArgumentException('Value must be instance of ' . Server::class);
        }

        parent::offsetSet($offset, $value);
    }

    public function offsetGet(mixed $offset): Server
    {
        return parent::offsetGet($offset);
    }
}