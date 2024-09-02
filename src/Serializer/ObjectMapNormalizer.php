<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Serializer;

use DeadMansSwitch\OpenAPI\Types\MapOfObjects;
use Symfony\Component\Serializer\Exception\UnexpectedPropertyException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class ObjectMapNormalizer implements DenormalizerInterface
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): MapOfObjects
    {
        $map = new $type;
        $serializer = SerializerFactory::create();

        if (!$map instanceof MapOfObjects) {
            throw new UnexpectedPropertyException('Unexpected property type MapOfObjects');
        }

        foreach ($data as $k => $v) {
            $type = $map::getType($v);

            $item = $serializer->denormalize(
                data: $v,
                type: $type,
            );

            $map[$k] = $item;
        }

        return $map;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        if ($data === null) {
            return false;
        }

        if (!is_iterable($data)) {
            return false;
        }

        if (!is_a($type, MapOfObjects::class, true)) {
            return false;
        }

        return true;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            MapOfObjects::class => true,
        ];
    }
}