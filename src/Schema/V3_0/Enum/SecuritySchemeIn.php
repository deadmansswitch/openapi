<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0\Enum;

enum SecuritySchemeIn: string
{
    case Query = 'query';
    case Header = 'header';
    case Cookie = 'cookie';
}