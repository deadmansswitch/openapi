<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Enum\SecuritySchemeHttpAuthScheme;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Enum\SecuritySchemeIn;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Enum\SecuritySchemeType;

final class SecurityScheme
{
    public function __construct(
        public SecuritySchemeType $type,
        public ?string $description = null,
        public ?string $name = null,
        public ?SecuritySchemeIn $in = null,
        public ?SecuritySchemeHttpAuthScheme $scheme = null,
        public ?string $bearerFormat = null,
        public ?OAuthFlows $flows = null,
        public ?string $openIdConnectUrl = null,
    ) {}
}