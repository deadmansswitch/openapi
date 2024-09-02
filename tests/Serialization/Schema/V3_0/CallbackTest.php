<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Callback;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\MediaTypeMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\MediaType;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Operation;
use DeadMansSwitch\OpenAPI\Schema\V3_0\PathItem;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Reference;
use DeadMansSwitch\OpenAPI\Schema\V3_0\RequestBody;
use DeadMansSwitch\OpenAPI\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class CallbackTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, Callback $schema): void
    {
        $actual = $this->serializer->deserialize($json, Callback::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, Callback $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield [
            'json' => '{
                "{$request.query.queryUrl}": {
                    "post": {
                        "requestBody": {
                            "description": "Callback payload",
                            "content": {
                                "application/json": {
                                    "schema": {
                                        "$ref": "#/components/schemas/SomePayload"
                                    }
                                }
                            }
                        }
                    }
                } 
            }',
            'schema' => Callback::fromArray([
                '{$request.query.queryUrl}' => new PathItem(
                    post: new Operation(
                        requestBody: new RequestBody(
                            content: MediaTypeMap::fromArray([
                                'application/json' => new MediaType(
                                    schema: new Reference(ref: '#/components/schemas/SomePayload'),
                                ),
                            ]),
                            description: 'Callback payload',
                        ),
                    ),
                ),
            ]),
        ];
    }
}