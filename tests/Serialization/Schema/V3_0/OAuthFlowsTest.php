<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenApi\Schema\V3_0\OAuthFlow;
use DeadMansSwitch\OpenApi\Schema\V3_0\OAuthFlows;
use DeadMansSwitch\OpenApi\Serializer\SerializerFactory;
use DeadMansSwitch\OpenApi\Types\MapOfStrings;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class OAuthFlowsTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, OAuthFlows $schema): void
    {
        $actual = $this->serializer->deserialize($json, OAuthFlows::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, OAuthFlows $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield 'All populated' => [
            'json' => '{
                "implicit": {
                    "authorizationUrl": "https://example.com/authorization",
                    "scopes": {
                        "read:pets": "Read your pets",
                        "write:pets": "Modify your pets"
                    }
                },
                "password": {
                    "authorizationUrl": "https://example.com/authorization",
                    "tokenUrl": "https://example.com/token",
                    "scopes": {
                        "read:pets": "Read your pets",
                        "write:pets": "Modify your pets"
                    }
                },
                "clientCredentials": {
                    "authorizationUrl": "https://example.com/authorization",
                    "tokenUrl": "https://example.com/token",
                    "scopes": {
                        "read:pets": "Read your pets",
                        "write:pets": "Modify your pets"
                    }
                },
                "authorizationCode": {
                    "authorizationUrl": "https://example.com/authorization",
                    "tokenUrl": "https://example.com/token",
                    "scopes": {
                        "read:pets": "Read your pets",
                        "write:pets": "Modify your pets"
                    }
                }
            }',
            'schema' => new OAuthFlows(
                implicit: new OAuthFlow(
                    authorizationUrl: 'https://example.com/authorization',
                    scopes: MapOfStrings::fromArray([
                        'read:pets' => 'Read your pets',
                        'write:pets' => 'Modify your pets',
                    ]),
                ),
                password: new OAuthFlow(
                    authorizationUrl: 'https://example.com/authorization',
                    scopes: MapOfStrings::fromArray([
                        'read:pets' => 'Read your pets',
                        'write:pets' => 'Modify your pets',
                    ]),
                    tokenUrl: 'https://example.com/token',
                ),
                clientCredentials: new OAuthFlow(
                    authorizationUrl: 'https://example.com/authorization',
                    scopes: MapOfStrings::fromArray([
                        'read:pets' => 'Read your pets',
                        'write:pets' => 'Modify your pets',
                    ]),
                    tokenUrl: 'https://example.com/token',
                ),
                authorizationCode: new OAuthFlow(
                    authorizationUrl: 'https://example.com/authorization',
                    scopes: MapOfStrings::fromArray([
                        'read:pets' => 'Read your pets',
                        'write:pets' => 'Modify your pets',
                    ]),
                    tokenUrl: "https://example.com/token",
                ),
            ),
        ];
    }
}