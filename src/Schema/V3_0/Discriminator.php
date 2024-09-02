<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Types\MapOfStrings;

final class Discriminator
{
    public function __construct(
        public string $propertyName,
        public ?MapOfStrings $mapping = null,
    ) {}
}