<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Schema\V3_0\Enum;

enum SecuritySchemeHttpAuthScheme: string
{
    case Basic = 'basic';
    case Bearer = 'bearer';
    case Digest = 'digest';
    case Dpop = 'dpop';
    case Gnap = 'gnap';
    case Hoba = 'hoba';
    case Mutual = 'mutual';
    case Negotiate = 'negotiate';
    case Oauth = 'oauth';
    case PrivateToken = 'privateToken';
    case ScramSha1 = 'scramSha1';
    case ScramSha256 = 'scramSha256';
    case Vapid = 'vapid';
}