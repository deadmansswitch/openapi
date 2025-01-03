<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0;

final class ExternalDocumentation
{
    public function __construct(
        public ?string $description,
        public string $url,
    ) {}
}