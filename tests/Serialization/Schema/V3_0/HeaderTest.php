<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Header;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Schema;
use DeadMansSwitch\OpenAPI\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class HeaderTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, Header $schema): void
    {
        $actual = $this->serializer->deserialize($json, Header::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, Header $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield [
            'json' => '{
                "description": "The number of allowed requests in the current period",
                "schema": {
                    "type": "integer"
                }
            }',
            'schema' => new Header(
                description: 'The number of allowed requests in the current period',
                schema: new Schema(
                    type: 'integer',
                ),
            ),
        ];
    }
}