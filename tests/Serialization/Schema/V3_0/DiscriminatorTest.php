<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Discriminator;
use DeadMansSwitch\OpenAPI\Serializer\SerializerFactory;
use DeadMansSwitch\OpenAPI\Types\MapOfStrings;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class DiscriminatorTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('deserializeDataProvider')]
    public function testDeserialize(string $json, ?Discriminator $schema = null, ?string $exception = null): void
    {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        $actual = $this->serializer->deserialize($json, Discriminator::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    public static function deserializeDataProvider(): iterable
    {
        yield [
            'json' => '{
                "propertyName": "petType",
                "mapping": {
                    "dog": "#/components/schemas/Dog",
                    "monster": "https://gigantic-server.com/schemas/Monster/schema.json"
                }
            }',
            'schema' => new Discriminator(
                propertyName: 'petType',
                mapping: MapOfStrings::fromArray([
                    'dog' => '#/components/schemas/Dog',
                    'monster' => 'https://gigantic-server.com/schemas/Monster/schema.json',
                ]),
            ),
        ];
    }

    #[DataProvider('serializeDataProvider')]
    public function testSerialize(Discriminator $schema, ?string $json = null, ?string $exception = null): void
    {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function serializeDataProvider(): iterable
    {
        yield [
            'schema' => new Discriminator(
                propertyName: 'petType',
                mapping: MapOfStrings::fromArray([
                    'dog' => '#/components/schemas/Dog',
                    'monster' => 'https://gigantic-server.com/schemas/Monster/schema.json',
                ]),
            ),
            'json' => '{
                "propertyName": "petType",
                "mapping": {
                    "dog": "#/components/schemas/Dog",
                    "monster": "https://gigantic-server.com/schemas/Monster/schema.json"
                }
            }',
        ];
    }
}