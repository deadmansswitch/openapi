<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Schema\V3_0;

use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\HeadersMap;

final class Encoding
{
    public function __construct(
        public ?string $contentType = null,
        public ?HeadersMap $headers = null,
        public ?string $style = null,
        public ?bool $explode = null,
        public ?bool $allowReserved = null,
    ) {}
}