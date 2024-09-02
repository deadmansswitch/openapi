<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Example;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\ExamplesMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\MediaTypeMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\MediaType;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Reference;
use DeadMansSwitch\OpenAPI\Schema\V3_0\RequestBody;
use DeadMansSwitch\OpenAPI\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class RequestBodyTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, RequestBody $schema): void
    {
        $actual = $this->serializer->deserialize($json, RequestBody::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, RequestBody $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield [
            'json' => '{
                "description": "user to add to the system",
                "content": {
                    "application/json": {
                        "schema": {
                            "$ref": "#/components/schemas/User"
                        },
                        "examples": {
                            "user" : {
                                "summary": "User Example",
                                "externalValue": "https://foo.bar/examples/user-example.json"
                            }
                        }
                    },
                    "application/xml": {
                        "schema": {
                            "$ref": "#/components/schemas/User"
                        },
                        "examples": {
                            "user" : {
                                "summary": "User example in XML",
                                "externalValue": "https://foo.bar/examples/user-example.xml"
                            }
                        }
                    },
                    "text/plain": {
                        "examples": {
                            "user" : {
                                "summary": "User example in Plain text",
                                "externalValue": "https://foo.bar/examples/user-example.txt"
                            }
                        }
                    },
                    "*/*": {
                        "examples": {
                            "user" : {
                                "summary": "User example in other format",
                                "externalValue": "https://foo.bar/examples/user-example.whatever"
                            }
                        }
                    }
                }
            }',
            'schema' => new RequestBody(
                content: MediaTypeMap::fromArray([
                    'application/json' => new MediaType(
                        schema: new Reference(ref: '#/components/schemas/User'),
                        examples: ExamplesMap::fromArray([
                            'user' => new Example(
                                summary: 'User Example',
                                externalValue: 'https://foo.bar/examples/user-example.json',
                            ),
                        ]),
                    ),
                    'application/xml' => new MediaType(
                        schema: new Reference(ref: '#/components/schemas/User'),
                        examples: ExamplesMap::fromArray([
                            'user' => new Example(
                                summary: 'User example in XML',
                                externalValue: 'https://foo.bar/examples/user-example.xml',
                            ),
                        ]),
                    ),
                    'text/plain' => new MediaType(
                        examples: ExamplesMap::fromArray([
                            'user' => new Example(
                                summary: 'User example in Plain text',
                                externalValue: 'https://foo.bar/examples/user-example.txt',
                            ),
                        ]),
                    ),
                    '*/*' => new MediaType(
                        examples: ExamplesMap::fromArray([
                            'user' => new Example(
                                summary: 'User example in other format',
                                externalValue: 'https://foo.bar/examples/user-example.whatever',
                            ),
                        ]),
                    ),
                ]),
                description: 'user to add to the system',
            ),
        ];
    }
}