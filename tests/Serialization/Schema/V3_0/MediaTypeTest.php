<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenApi\Schema\V3_0\Example;
use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\ExamplesMap;
use DeadMansSwitch\OpenApi\Schema\V3_0\MediaType;
use DeadMansSwitch\OpenApi\Schema\V3_0\Reference;
use DeadMansSwitch\OpenApi\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class MediaTypeTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, MediaType $schema): void
    {
        $actual = $this->serializer->deserialize($json, MediaType::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, MediaType $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield [
            'json' => '{
                "schema": {
                    "$ref": "#/components/schemas/Pet"
                },
                "examples": {
                    "cat": {
                        "summary": "An example of a cat",
                        "value": {
                            "name": "Fluffy",
                            "petType": "Cat",
                            "color": "White",
                            "gender": "male",
                            "breed": "Persian"
                        }
                    },
                    "dog": {
                        "summary": "An example of a dog with a cat\'s name",
                        "value": {
                            "name": "Puma",
                            "petType": "Dog",
                            "color": "Black",
                            "gender": "female",
                            "breed": "Mixed"
                        }
                    },
                    "frog": {
                        "$ref": "#/components/examples/frog-example"
                    }
                }
            }',
            'schema' => new MediaType(
                schema: new Reference(ref: '#/components/schemas/Pet'),
                examples: ExamplesMap::fromArray([
                    'cat' => new Example(
                        summary: 'An example of a cat',
                        value: [
                            'name' => 'Fluffy',
                            'petType' => 'Cat',
                            'color' => 'White',
                            'gender' => 'male',
                            'breed' => 'Persian',
                        ],
                    ),
                    'dog' => new Example(
                        summary: 'An example of a dog with a cat\'s name',
                        value: [
                            'name' => 'Puma',
                            'petType' => 'Dog',
                            'color' => 'Black',
                            'gender' => 'female',
                            'breed' => 'Mixed',
                        ],
                    ),
                    'frog' => new Reference(ref: '#/components/examples/frog-example')
                ]),
            ),
        ];
    }
}