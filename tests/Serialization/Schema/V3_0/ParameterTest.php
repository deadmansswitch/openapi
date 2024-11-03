<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Parameter;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Schema;
use DeadMansSwitch\OpenAPI\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class ParameterTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, Parameter $schema): void
    {
        $actual = $this->serializer->deserialize($json, Parameter::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, Parameter $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield [
            'json' => '{
                "name": "token",
                "in": "header",
                "description": "token to be passed as a header",
                "required": true,
                "schema": {
                    "type": "array",
                    "items": {
                        "type": "integer",
                        "format": "int64"
                    }
                },
                "style": "simple"
            }',
            'schema' => new Parameter(
                name: 'token',
                in: 'header',
                description: 'token to be passed as a header',
                required: true,
                style: 'simple',
                schema: new Schema(
                    type: 'array',
                    items: new Schema(
                        type: 'integer',
                        format: 'int64',
                    ),
                ),
            ),
        ];

        yield [
            'json' => '{
                "name": "order",
                "in": "query",
                "description": "query direction",
                "required": true,
                "schema": {
                    "type": "string",
                    "enum": ["asc", "desc"]
                }
            }',
            'schema' => new Parameter(
                name: 'order',
                in: 'query',
                description: 'query direction',
                required: true,
                schema: new Schema(
                    type: 'string',
                    enum: ['asc', 'desc'],
                ),
            ),
        ];
    }
}