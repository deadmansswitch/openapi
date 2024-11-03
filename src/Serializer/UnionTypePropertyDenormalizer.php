<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Serializer;

use LogicException;
use ReflectionClass;
use DeadMansSwitch\OpenApi\Types\UnionTypePropertyOwner;
use ReflectionException;
use ReflectionNamedType;
use ReflectionUnionType;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final readonly class UnionTypePropertyDenormalizer implements DenormalizerInterface
{
    public const BREAKER = '5a6740d9-acab-4ee4-a4C8-4a40828b4653';

    /**
     * @throws ReflectionException
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): UnionTypePropertyOwner
    {
        $serializer = SerializerFactory::create();
        $reflection = new ReflectionClass($type);
        $prepared   = [];

        foreach ($data as $key => $value)  {
            if (!$reflection->hasProperty($key)) {
                continue;
            }

            $property = $reflection->getProperty($key);
            $returnType = $property->getType();

            if ($returnType === null) {
                $prepared[$key] = $value;
                continue;
            }

            if ($returnType instanceof ReflectionNamedType) {
                $prepared[$key] = $value;
                continue;
            }

            if ($returnType instanceof ReflectionUnionType) {
                if (!method_exists($type, 'getType')) {
                    throw new LogicException('Invalid property: ' . $key);
                }

                $hint = $type::getType($key, $value);

                $prepared[$key] = $serializer->denormalize($value, $hint);
            }
        }

        return $serializer->denormalize($prepared, $type, context: $context + [self::BREAKER => true]);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        if ($context[self::BREAKER] ?? false) {
            return false;
        }

        if (!is_a($type, UnionTypePropertyOwner::class, true)) {
            return false;
        }

        return true;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            '*' => false,
        ];
    }
}