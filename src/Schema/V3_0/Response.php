<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0;

use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\HeadersMap;
use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\LinksMap;
use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\MediaTypeMap;

final class Response
{
    public function __construct(
        public string $description,
        public ?HeadersMap $headers = null,
        public ?MediaTypeMap $content = null,
        public ?LinksMap $links = null,
    ) {}
}