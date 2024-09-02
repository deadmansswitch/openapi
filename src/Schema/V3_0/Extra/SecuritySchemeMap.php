<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Schema\V3_0\Extra;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Reference;
use DeadMansSwitch\OpenAPI\Schema\V3_0\SecurityScheme;
use DeadMansSwitch\OpenAPI\Types\MapOfObjects;
use TypeError;

final class SecuritySchemeMap extends MapOfObjects
{
    static function getType(mixed $data): string
    {
        if (!is_array($data)) {
            throw new TypeError('Data must be an array');
        }

        if (array_key_exists('$ref', $data)) {
            return Reference::class;
        }

        return SecurityScheme::class;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$value instanceof SecurityScheme && !$value instanceof Reference) {
            throw new TypeError('Value must be an instance of SecurityScheme or Reference');
        }

        parent::offsetSet($offset, $value);
    }

    public function offsetGet(mixed $offset): SecurityScheme|Reference
    {
        return parent::offsetGet($offset);
    }
}