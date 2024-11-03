<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0\Enum;

enum SecuritySchemeType: string
{
    case ApiKey = 'apiKey';
    case Http = 'http';
    case MutualTls = 'mutualTLS';
    case Oauth2 = 'oauth2';
    case OpenIdConnect = 'openIdConnect';
}