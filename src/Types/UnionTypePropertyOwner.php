<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Types;

abstract class UnionTypePropertyOwner
{
    abstract static function getType(string $property, mixed $value): string|null;
}