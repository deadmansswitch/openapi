<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenApi\Schema\V3_0\OAuthFlow;
use DeadMansSwitch\OpenApi\Serializer\SerializerFactory;
use DeadMansSwitch\OpenApi\Types\MapOfStrings;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class OAuthFlowTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, OAuthFlow $schema): void
    {
        $actual = $this->serializer->deserialize($json, OAuthFlow::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, OAuthFlow $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield [
            'json' => '{
                "authorizationUrl": "https://example.com/api/oauth/dialog",
                "scopes": {
                    "write:pets": "modify pets in your account",
                    "read:pets": "read your pets"
                }
            }',
            'schema' => new OAuthFlow(
                authorizationUrl: 'https://example.com/api/oauth/dialog',
                scopes: MapOfStrings::fromArray([
                    'write:pets' => 'modify pets in your account',
                    'read:pets' => 'read your pets',
                ]),
            ),
        ];

        yield [
            'json' => '{
                "authorizationUrl": "https://example.com/api/oauth/dialog",
                "tokenUrl": "https://example.com/api/oauth/token",
                "scopes": {
                    "write:pets": "modify pets in your account",
                    "read:pets": "read your pets"
                }
            }',
            'schema' => new OAuthFlow(
                authorizationUrl: 'https://example.com/api/oauth/dialog',
                scopes: MapOfStrings::fromArray([
                    'write:pets' => 'modify pets in your account',
                    'read:pets' => 'read your pets',
                ]),
                tokenUrl: 'https://example.com/api/oauth/token',
            ),
        ];
    }
}