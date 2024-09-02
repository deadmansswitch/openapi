<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\MediaTypeMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\MediaType;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Operation;
use DeadMansSwitch\OpenAPI\Schema\V3_0\PathItem;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Paths;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Reference;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Response;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Responses;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Schema;
use DeadMansSwitch\OpenAPI\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class PathsTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, Paths $schema): void
    {
        $actual = $this->serializer->deserialize($json, Paths::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, Paths $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield [
            'json' => '{
                "/pets": {
                    "get": {
                        "description": "Returns all pets from the system that the user has access to",
                        "responses": {
                            "200": {         
                                "description": "A list of pets.",
                                "content": {
                                    "application/json": {
                                        "schema": {
                                            "type": "array",
                                            "items": {
                                                "$ref": "#/components/schemas/pet"
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }',
            'schema' => Paths::fromArray([
                '/pets' => new PathItem(
                    get: new Operation(
                        description: 'Returns all pets from the system that the user has access to',
                        responses: Responses::fromArray([
                            '200' => new Response(
                                description: 'A list of pets.',
                                content: MediaTypeMap::fromArray([
                                    'application/json' => new MediaType(
                                        schema: new Schema(
                                            type: 'array',
                                            items: new Reference(ref: '#/components/schemas/pet')
                                        ),
                                    ),
                                ]),
                            ),
                        ]),
                    ),
                ),
            ]),
        ];
    }
}