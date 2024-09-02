<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Schema\V3_0\Enum;

enum SecuritySchemeIn: string
{
    case Query = 'query';
    case Header = 'header';
    case Cookie = 'cookie';
}