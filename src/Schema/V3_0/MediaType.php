<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0;

use LogicException;
use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\EncodingMap;
use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\ExamplesMap;
use DeadMansSwitch\OpenApi\Types\UnionTypePropertyOwner;

final class MediaType extends UnionTypePropertyOwner
{
    public function __construct(
        public Schema|Reference|null $schema = null,
        public mixed $example = null,
        public ?ExamplesMap $examples = null,
        public ?EncodingMap $encoding = null,
    ) {}

    static function getType(string $property, mixed $value): string|null
    {
        if ($property !== 'schema') {
            throw new LogicException('Invalid property: ' . $property);
        }

        if ($value === null) {
            return null;
        }

        if (is_array($value) && array_key_exists('$ref', $value)) {
            return Reference::class;
        }

        if (is_array($value) && array_intersect(array_keys($value), ['type', 'properties'])) {
            return Schema::class;
        }

        throw new LogicException('Invalid property: ' . $property);
    }
}