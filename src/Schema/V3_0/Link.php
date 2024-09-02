<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Schema\V3_0;

final class Link
{
    public function __construct(
        public ?string $operationRef = null,
        public ?string $operationId = null,
        /** @var array<array-key, mixed> */
        public ?array $parameters = null,
        public mixed $requestBody = null,
        public ?string $description = null,
        public ?Server $server = null,
    ) {}
}