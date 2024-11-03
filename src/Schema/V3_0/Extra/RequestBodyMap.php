<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0\Extra;

use DeadMansSwitch\OpenApi\Schema\V3_0\Reference;
use DeadMansSwitch\OpenAPI\Schema\V3_0\RequestBody;
use DeadMansSwitch\OpenAPI\Types\MapOfObjects;
use TypeError;

final class RequestBodyMap extends MapOfObjects
{
    static function getType(mixed $data): string
    {
        if (!is_array($data)) {
            throw new TypeError('Data must be an array');
        }

        if (array_key_exists('$ref', $data)) {
            return Reference::class;
        }

        return RequestBody::class;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$value instanceof RequestBody && !$value instanceof Reference) {
            throw new TypeError('Value must be an instance of RequestBody or Reference');
        }

        parent::offsetSet($offset, $value);
    }

    public function offsetGet(mixed $offset): RequestBody|Reference
    {
        return parent::offsetGet($offset);
    }
}