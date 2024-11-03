<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenApi\Schema\V3_0\Contact;
use DeadMansSwitch\OpenApi\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;
use TypeError;

#[CoversNothing]
final class ContactTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('deserializeDataProvider')]
    public function testDeserialize(string $json, ?Contact $expected = null, ?string $exception = null): void
    {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        $actual = $this->serializer->deserialize($json, Contact::class, 'json');

        $this->assertEquals($expected, $actual);
    }

    public static function deserializeDataProvider(): iterable
    {
        yield 'All good: official example' => [
            'json'      => '{
                "name": "API Support",
                "url": "https://www.example.com/support",
                "email": "support@example.com"
            }',
            'expected'    => new Contact(
                name: 'API Support',
                url: 'https://www.example.com/support',
                email: 'support@example.com',
            ),
        ];

        yield 'All good: properties is set to null' => [
            'json'      => '{
                "name": null,
                "url": null,
                "email": null
            }',
            'expected'    => new Contact(
                name: null,
                url: null,
                email: null,
            ),
        ];

        yield 'All good: properties are non-string scalars' => [
            'json'      => '{
                "name": true,
                "url": 123,
                "email": false
            }',
            'expected'    => new Contact(
                name: "1",
                url: "123",
                email: "",
            ),
        ];

        yield 'Unexpected: Properties are not scalars' => [
            'json'      => '{
                "name": [],
                "url": {},
                "email": "foo@bar.baz"
            }',
            'exception' => TypeError::class,
        ];
    }

    #[DataProvider('serializeDataProvider')]
    public function testSerialize(Contact $schema, string $json, string|null $exception = null): void
    {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function serializeDataProvider(): iterable
    {
        yield 'All good: properties filled properly' => [
            'schema' => new Contact(
                name: 'API Support',
                url: 'https://www.example.com/support',
                email: 'foo@bar.baz',
            ),
            'json' => '{
                "name": "API Support",
                "url": "https://www.example.com/support",
                "email": "foo@bar.baz"
            }',
        ];
    }
}