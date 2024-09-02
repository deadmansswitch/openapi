<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Reference;
use DeadMansSwitch\OpenAPI\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class ReferenceTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('deserializeDataProvider')]
    public function testDeserialize(string $json, ?Reference $expected = null, ?string $exception = null): void
    {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        $actual = $this->serializer->deserialize($json, Reference::class, 'json');

        $this->assertEquals($expected, $actual);
    }

    public static function deserializeDataProvider(): iterable
    {
        yield 'Official example #1: Reference Object Example' => [
            'json' => '{
                "$ref": "#/components/schemas/Pet"
            }',
            'expected' => new Reference(
                ref: '#/components/schemas/Pet',
            ),
        ];

        yield 'Official example #2: Relative Schema Document Example' => [
            'json' => '{
                "$ref": "Pet.json"
            }',
            'expected' => new Reference(
                ref: 'Pet.json',
            ),
        ];

        yield 'Official example #3: Relative Documents With Embedded Schema Example' => [
            'json' => '{
                "$ref": "definitions.json#/Category"
            }',
            'expected' => new Reference(
                ref: 'definitions.json#/Category',
            ),
        ];
    }
}