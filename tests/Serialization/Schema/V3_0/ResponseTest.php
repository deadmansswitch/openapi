<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\HeadersMap;
use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\MediaTypeMap;
use DeadMansSwitch\OpenApi\Schema\V3_0\Header;
use DeadMansSwitch\OpenApi\Schema\V3_0\MediaType;
use DeadMansSwitch\OpenApi\Schema\V3_0\Reference;
use DeadMansSwitch\OpenApi\Schema\V3_0\Response;
use DeadMansSwitch\OpenApi\Schema\V3_0\Schema;
use DeadMansSwitch\OpenApi\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class ResponseTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, Response $schema): void
    {
        $actual = $this->serializer->deserialize($json, Response::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, Response $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield 'Response of an array of a complex type' => [
            'json' => '{
                "description": "A complex object array response",
                "content": {
                    "application/json": {
                        "schema": {
                            "type": "array",
                            "items": {
                                "$ref": "#/components/schemas/VeryComplexType"
                            }
                        }
                    }
                }
            }',
            'schema' => new Response(
                description: 'A complex object array response',
                content: MediaTypeMap::fromArray([
                    'application/json' => new MediaType(
                        schema: new Schema(
                            type: 'array',
                            items: new Reference(ref: '#/components/schemas/VeryComplexType'),
                        ),
                    ),
                ]),
            ),
        ];

        yield 'Response with a string type' => [
            'json' => '{
                "description": "A simple string response",
                "content": {
                    "text/plain": {
                        "schema": {
                            "type": "string"
                        }
                    }
                }
            }',
            'schema' => new Response(
                description: 'A simple string response',
                content: MediaTypeMap::fromArray([
                    'text/plain' => new MediaType(
                        schema: new Schema(
                            type: 'string',
                        ),
                    ),
                ]),
            ),
        ];

        yield 'Plain text response with headers' => [
            'json' => '{
                "description": "A simple string response",
                "content": {
                    "text/plain": {
                        "schema": {
                            "type": "string",
                            "example": "whoa!"
                        }
                    }
                },
                "headers": {
                    "X-Rate-Limit-Limit": {
                        "description": "The number of allowed requests in the current period",
                        "schema": {
                            "type": "integer"
                        }
                    },
                    "X-Rate-Limit-Remaining": {
                        "description": "The number of remaining requests in the current period",
                        "schema": {
                            "type": "integer"
                        }
                    },
                    "X-Rate-Limit-Reset": {
                        "description": "The number of seconds left in the current period",
                        "schema": {
                            "type": "integer"
                        }
                    }
                }
            }',
            'schema' => new Response(
                description: 'A simple string response',
                headers: HeadersMap::fromArray([
                    'X-Rate-Limit-Limit' => new Header(
                        description: 'The number of allowed requests in the current period',
                        schema: new Schema(type: 'integer'),
                    ),
                    'X-Rate-Limit-Remaining' => new Header(
                        description: 'The number of remaining requests in the current period',
                        schema: new Schema(type: 'integer'),
                    ),
                    'X-Rate-Limit-Reset' => new Header(
                        description: 'The number of seconds left in the current period',
                        schema: new Schema(type: 'integer'),
                    ),
                ]),
                content: MediaTypeMap::fromArray([
                    'text/plain' => new MediaType(
                        schema: new Schema(
                            type: 'string',
                            example: 'whoa!',
                        ),
                    ),
                ]),
            ),
        ];

        yield 'Response with no return value' => [
            'json' => '{
                "description": "No content response"
            }',
            'schema' => new Response(
                description: 'No content response',
            ),
        ];
    }
}