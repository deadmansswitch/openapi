<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0;

use DeadMansSwitch\OpenApi\Types\MapOfStrings;

final class OAuthFlow
{
    public function __construct(
        public string $authorizationUrl,
        public MapOfStrings $scopes,
        public ?string $tokenUrl = null,
        public ?string $refreshUrl = null,
    ) {}
}