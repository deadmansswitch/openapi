<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0;

final class OAuthFlows
{
    public function __construct(
        public ?OAuthFlow $implicit = null,
        public ?OAuthFlow $password = null,
        public ?OAuthFlow $clientCredentials = null,
        public ?OAuthFlow $authorizationCode = null,
    ) {}
}