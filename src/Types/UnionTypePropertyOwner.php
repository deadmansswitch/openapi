<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Types;

abstract class UnionTypePropertyOwner
{
    abstract static function getType(string $property, mixed $value): string|null;
}