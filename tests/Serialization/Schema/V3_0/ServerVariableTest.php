<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenApi\Schema\V3_0\ServerVariable;
use DeadMansSwitch\OpenApi\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class ServerVariableTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('deserializeDataProvider')]
    public function testDeserialize(string $json, ?ServerVariable $schema = null, ?string $exception = null): void
    {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        $actual = $this->serializer->deserialize($json, ServerVariable::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    public static function deserializeDataProvider(): iterable
    {
        yield 'All properties filled' => [
            'json' => '{
                "enum": [
                    "option1",
                    "option2",
                    "option3"
                ],
                "default": "default",
                "description": "description"
            }',
            'schema' => new ServerVariable(
                default: 'default',
                enum: [
                    'option1',
                    'option2',
                    'option3',
                ],
                description: 'description',
            ),
        ];
    }

    #[DataProvider('serializeDataProvider')]
    public function testSerialize(ServerVariable $schema, ?string $json = null, ?string $exception = null): void
    {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function serializeDataProvider(): iterable
    {
        yield 'All good' => [
            'schema' => new ServerVariable(
                default: 'default',
                enum: [
                    'option1',
                    'option2',
                    'option3',
                ],
                description: 'description',
            ),
            'json' => '{
                "default": "default",
                "enum": [
                    "option1",
                    "option2",
                    "option3"
                ],
                "description": "description"
            }',
        ];
    }
}