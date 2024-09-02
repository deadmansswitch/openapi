<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\MediaTypeMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\ExamplesMap;

final class Parameter
{
    public function __construct(
        public string $name,
        public string $in,
        public ?string $description = null,
        public ?bool $required = null,
        public ?bool $deprecated = null,
        public ?bool $allowEmptyValue = null,

        public ?string $style = null,
        public ?bool $explode = null,
        public ?bool $allowReserved = null,
        public ?Schema $schema = null,
        public mixed $example = null,
        public ?ExamplesMap $examples = null,
        public ?MediaTypeMap $content = null,
    ) {}
}