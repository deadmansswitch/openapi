<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Schema\V3_0;

use InvalidArgumentException;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\SchemasMap;
use DeadMansSwitch\OpenAPI\Types\UnionTypePropertyOwner;

final class Schema extends UnionTypePropertyOwner
{
    public function __construct(
        public ?string $type,
        public ?string $description = null,
        public ?string $format = null,
        public ?array $required = null,
        public ?SchemasMap $properties = null,
        public ?int $minimum = null,
        public Schema|Reference|null $items = null,
        public mixed $example = null,
    ) {}

    static function getType(string $property, mixed $value): string|null
    {
        // Get type for `items` property
        if ($property === 'items') {
            if ($value === null) {
                return null;
            }

            if (is_array($value) && array_key_exists('$ref', $value)) {
                return Reference::class;
            }

            if (is_array($value) && array_intersect(array_keys($value), ['type', 'properties'])) {
                return Schema::class;
            }

            return null;
        }

        throw new InvalidArgumentException();
    }
}