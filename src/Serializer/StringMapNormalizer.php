<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Serializer;

use DeadMansSwitch\OpenApi\Types\MapOfStrings;
use Symfony\Component\Serializer\Exception\UnexpectedPropertyException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class StringMapNormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $map = new $type;

        if (!$map instanceof MapOfStrings) {
            throw new UnexpectedPropertyException('Unexpected property type MapOfStrings');
        }

        foreach ($data as $k => $v) {
            $map[$k] = $v;
        }

        return $map;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        if (!is_iterable($data)) {
            return false;
        }

        if (is_a($type, MapOfStrings::class, true)) {
            return false;
        }

        return true;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => false];
    }
}