<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Schema\V3_0;

final class License
{
    public function __construct(
        public string $name,
        public ?string $identifier = null,
        public ?string $url = null,
    ) {}
}