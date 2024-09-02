<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Schema\V3_0;

use Symfony\Component\Serializer\Attribute\SerializedName;

final class Reference
{
    public function __construct(
        #[SerializedName('$ref')]
        public string $ref,
        public ?string $summary = null,
        public ?string $description = null,
    ) {}
}