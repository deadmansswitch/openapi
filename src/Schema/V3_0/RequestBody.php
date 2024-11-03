<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0;

use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\MediaTypeMap;

final class RequestBody
{
    public function __construct(
        public MediaTypeMap $content,
        public ?string $description = null,
        public ?bool $required = null,
    ) {}
}