<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Schema\V3_0;

final class Tag
{
    public function __construct(
        public string $name,
        public ?string $description = null,
        public ?ExternalDocumentation $externalDocs = null,
    ) {}
}