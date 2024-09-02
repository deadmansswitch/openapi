<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Serializer;

use ArrayAccess;
use DeadMansSwitch\OpenAPI\Types\MapOfObjects;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class ArrayAccessDenormalizer implements DenormalizerInterface
{
    public const CIRCUIT_BREAKER = '20e82c2c-36c3-4683-b6b5-5f21cf560d0f';

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $out = new $type;

        foreach ($data as $key => $value) {
            $out[$key] = $value;
        }

        return $out;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        if ($context[self::CIRCUIT_BREAKER] ?? false) {
            return false;
        }

        if (!is_iterable($data)) {
            return false;
        }

        if (!is_a($type, ArrayAccess::class, true)) {
            return false;
        }

        if (is_a($type, MapOfObjects::class, true))  {
            return false;
        }

        return true;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => false];
    }
}