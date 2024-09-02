<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Tests\Serialization\Schema\V3_0\Extra;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\ParametersMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Parameter;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Schema;
use DeadMansSwitch\OpenAPI\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class ParametersMapTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, ParametersMap $schema): void
    {
        $actual = $this->serializer->deserialize($json, ParametersMap::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, ParametersMap $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield 'Parameters map from Components example' => [
            'json' => '[
                {
                    "name": "skip",
                    "in": "query",
                    "description": "number of items to skip",
                    "required": true,
                    "schema": {
                        "type": "integer",
                        "format": "int32"
                    }
                },
                {
                    "name": "limit",
                    "in": "query",
                    "description": "max records to return",
                    "required": true,
                    "schema" : {
                        "type": "integer",
                        "format": "int32"
                    }
                }
            ]',
            'schema' => ParametersMap::fromArray([
                new Parameter(
                    name: 'skip',
                    in: 'query',
                    description: 'number of items to skip',
                    required: true,
                    schema: new Schema(
                        type: 'integer',
                        format: 'int32',
                    )
                ),
                new Parameter(
                    name: 'limit',
                    in: 'query',
                    description: 'max records to return',
                    required: true,
                    schema: new Schema(
                        type: 'integer',
                        format: 'int32',
                    )
                ),
            ]),
        ];
    }
}