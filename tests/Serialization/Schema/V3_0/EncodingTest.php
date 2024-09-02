<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Encoding;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Extra\HeadersMap;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Header;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Schema;
use DeadMansSwitch\OpenAPI\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class EncodingTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, Encoding $schema): void
    {
        $actual = $this->serializer->deserialize($json, Encoding::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, Encoding $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield [
            'json' => '{
                "contentType": "application/json"            
            }',
            'schema' => new Encoding(
                contentType: 'application/json',
            ),
        ];

        yield [
            'json' => '{
                "contentType": "image/png, image/jpeg",
                "headers": {
                    "X-Rate-Limit-Limit": {
                        "description": "The number of allowed requests in the current period",
                        "schema": {
                            "type": "integer"
                        }
                    }
                }
            }',
            'schema' => new Encoding(
                contentType: 'image/png, image/jpeg',
                headers: HeadersMap::fromArray([
                    'X-Rate-Limit-Limit' => new Header(
                        description: 'The number of allowed requests in the current period',
                        schema: new Schema(type: 'integer'),
                    ),
                ]),
            ),
        ];
    }
}