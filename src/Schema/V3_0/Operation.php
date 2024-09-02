<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\CallbackMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\ParametersMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\SecurityRequirementMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\ServerMap;
use DeadMansSwitch\OpenAPI\Types\MapOfStrings;

final class Operation
{
    public function __construct(
        public ?MapOfStrings $tags = null,
        public ?string $summary = null,
        public ?string $description = null,
        public ?ExternalDocumentation $externalDocs = null,
        public ?string $operationId = null,
        public ?ParametersMap $parameters = null,
        public ?RequestBody $requestBody = null,
        public ?Responses $responses = null,
        public ?CallbackMap $callbacks = null,
        public ?SecurityRequirementMap $security = null,
        public ?ServerMap $servers = null,
        public ?bool $deprecated = null,
    ) {}
}