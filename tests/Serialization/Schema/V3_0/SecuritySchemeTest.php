<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenAPI\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenAPI\Schema\V3_0\Enum\SecuritySchemeHttpAuthScheme;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Enum\SecuritySchemeIn;
use DeadMansSwitch\OpenAPI\Schema\V3_0\Enum\SecuritySchemeType;
use DeadMansSwitch\OpenAPI\Schema\V3_0\OAuthFlow;
use DeadMansSwitch\OpenAPI\Schema\V3_0\OAuthFlows;
use DeadMansSwitch\OpenAPI\Schema\V3_0\SecurityScheme;
use DeadMansSwitch\OpenAPI\Serializer\SerializerFactory;
use DeadMansSwitch\OpenAPI\Types\MapOfStrings;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class SecuritySchemeTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, SecurityScheme $schema): void
    {
        $actual = $this->serializer->deserialize($json, SecurityScheme::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, SecurityScheme $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield 'Basic Authentication Sample' => [
            'json' => '{
                "type": "http",
                "scheme": "basic"
            }',
            'schema' => new SecurityScheme(
                type: SecuritySchemeType::Http,
                scheme: SecuritySchemeHttpAuthScheme::Basic,
            ),
        ];

        yield 'API Key Sample' => [
            'json' => '{
                "type": "apiKey",
                "name": "api_key",
                "in": "header"
            }',
            'schema' => new SecurityScheme(
                type: SecuritySchemeType::ApiKey,
                name: 'api_key',
                in: SecuritySchemeIn::Header,
            ),
        ];

        yield 'JWT Bearer Sample' => [
            'json' => '{
                "type": "http",
                "scheme": "bearer",
                "bearerFormat": "JWT"
            }',
            'schema' => new SecurityScheme(
                type: SecuritySchemeType::Http,
                scheme: SecuritySchemeHttpAuthScheme::Bearer,
                bearerFormat: 'JWT',
            ),
        ];

        yield 'Implicit OAuth2 Sample' => [
            'json' => '{
                "type": "oauth2",
                "flows": {
                    "implicit": {
                        "authorizationUrl": "https://example.com/api/oauth/dialog",
                        "scopes": {
                            "write:pets": "modify pets in your account",
                            "read:pets": "read your pets"
                        }
                    }
                }
            }',
            'schema' => new SecurityScheme(
                type: SecuritySchemeType::Oauth2,
                flows: new OAuthFlows(
                    implicit: new OAuthFlow(
                        authorizationUrl: 'https://example.com/api/oauth/dialog',
                        scopes: MapOfStrings::fromArray([
                            'write:pets' => 'modify pets in your account',
                            'read:pets' => 'read your pets',
                        ]),
                    ),
                ),
            ),
        ];
    }
}