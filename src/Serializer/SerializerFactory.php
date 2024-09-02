<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Serializer;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final class SerializerFactory
{
    public static function create(): Serializer
    {
        $cmf = new ClassMetadataFactory(new AttributeLoader());
        $nc  = new MetadataAwareNameConverter($cmf);
        $ctx = [AbstractObjectNormalizer::SKIP_NULL_VALUES => true];

        return new Serializer(
            normalizers: [
                new EmptyObjectNormalizer(),
                new ArrayAccessDenormalizer(),
                new ObjectMapNormalizer(),
                new BackedEnumNormalizer(),
                new UnionTypePropertyDenormalizer(),
                new ObjectNormalizer($cmf, $nc, defaultContext: $ctx),
            ],
            encoders: [
                new JsonEncoder(),
            ],
        );
    }
}