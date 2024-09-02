<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\MediaTypeMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\MediaType;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Reference;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Response;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Responses;
use DeadMansSwitch\OpenAPI\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class ResponsesTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, Responses $schema): void
    {
        $actual = $this->serializer->deserialize($json, Responses::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, Responses $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield [
            'json' => '{
                "200": {
                    "description": "a pet to be returned",
                    "content": {
                        "application/json": {
                            "schema": {
                                "$ref": "#/components/schemas/Pet"
                            }
                        }
                    }
                },
                "default": {
                    "description": "Unexpected error",
                    "content": {
                        "application/json": {
                            "schema": {
                                "$ref": "#/components/schemas/ErrorModel"
                            }
                        }
                    }
                }
            }',
            'schema' => Responses::fromArray([
                '200' => new Response(
                    description: 'a pet to be returned',
                    content: MediaTypeMap::fromArray([
                        'application/json' => new MediaType(
                            schema: new Reference(ref: '#/components/schemas/Pet')
                        ),
                    ]),
                ),
                'default' => new Response(
                    description: 'Unexpected error',
                    content: MediaTypeMap::fromArray([
                        'application/json' => new MediaType(
                            schema: new Reference(ref: '#/components/schemas/ErrorModel')
                        ),
                    ]),
                ),
            ]),
        ];
    }
}