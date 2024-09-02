<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\ServerVariablesMap;

final class Server
{
    public function __construct(
        public string $url,
        public ?string $description = null,
        public ?ServerVariablesMap $variables = null,
    ) {}
}