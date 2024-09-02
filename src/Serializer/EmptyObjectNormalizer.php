<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Serializer;

use ArrayObject;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class EmptyObjectNormalizer implements NormalizerInterface
{
    public function normalize(mixed $object, string $format = null, array $context = []): ArrayObject
    {
        return new ArrayObject();
    }

    /**
     * @throws ReflectionException
     */
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        if (!is_object($data)) {
            return false;
        }

        $empty = true;
        $ref    = new ReflectionClass($data);
        $props  = $ref->getProperties();

        foreach ($props as $prop) {
            if ($empty === false) {
                continue;
            }

            $value = $prop->getValue($data);

            if (!empty($value)) {
                $empty = false;
            }
        }

        return $empty;
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['object' => false];
    }
}