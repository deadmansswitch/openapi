<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0;

use DeadMansSwitch\OpenApi\Types\MapOfStrings;

final class Discriminator
{
    public function __construct(
        public string $propertyName,
        public ?MapOfStrings $mapping = null,
    ) {}
}