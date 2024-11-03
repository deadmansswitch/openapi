<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0;

final class ServerVariable
{
    public function __construct(
        public string $default,
        public ?array $enum = null,
        public ?string $description = null,
    ) {}
}