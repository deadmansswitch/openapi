<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\SecurityRequirementMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\ServerMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\TagMap;

final class OpenApi
{
    public function __construct(
        public string $openapi,
        public Info $info,
        public ?string $jsonSchemaDialect = null,
        public ?ServerMap $servers = null,
        public ?Paths $paths = null,
        public ?Paths $webhooks = null,
        public ?Components $components = null,
        public ?SecurityRequirementMap $security = null,
        public ?TagMap $tags = null,
        public ?ExternalDocumentation $externalDocs = null,
    ) {}
}