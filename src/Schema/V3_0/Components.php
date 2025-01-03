<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0;

use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\CallbackMap;
use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\ExamplesMap;
use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\HeadersMap;
use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\LinksMap;
use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\ParametersMap;
use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\RequestBodyMap;
use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\SchemasMap;
use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\SecuritySchemeMap;

final class Components
{
    public function __construct(
        public ?SchemasMap $schemas = null,
        public ?Responses $responses = null,
        public ?ParametersMap $parameters = null,
        public ?ExamplesMap $examples = null,
        public ?RequestBodyMap $requestBodies = null,
        public ?HeadersMap $headers = null,
        public ?SecuritySchemeMap $securitySchemes = null,
        public ?LinksMap $links = null,
        public ?CallbackMap $callbacks = null,
        public ?Paths $pathItems = null,
    ) {}
}