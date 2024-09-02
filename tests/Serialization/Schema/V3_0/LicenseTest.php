<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\License;
use DeadMansSwitch\OpenAPI\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class LicenseTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('deserializeDataProvider')]
    public function testDeserialize(string $json, License $schema): void
    {
        $actual = $this->serializer->deserialize($json, License::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    public static function deserializeDataProvider(): iterable
    {
        yield [
            'json' => '{
                "name": "Apache 2.0",
                "identifier": "Apache-2.0"
            }',
            'schema' => new License(
                name: 'Apache 2.0',
                identifier: 'Apache-2.0',
            ),
        ];
    }

    #[DataProvider('serializeDataProvider')]
    public function testSerialize(License $schema, string $json): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function serializeDataProvider(): iterable
    {
        yield [
            'schema' => new License(
                name: 'Apache 2.0',
                identifier: 'Apache-2.0',
            ),
            'json' => '{
                "name": "Apache 2.0",
                "identifier": "Apache-2.0"
            }',
        ];
    }
}