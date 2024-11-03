<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenApi\Schema\V3_0\Extra\ServerVariablesMap;
use DeadMansSwitch\OpenApi\Schema\V3_0\Server;
use DeadMansSwitch\OpenApi\Schema\V3_0\ServerVariable;
use DeadMansSwitch\OpenApi\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class ServerTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('deserializeDataProvider')]
    public function testDeserialize(string $json, ?Server $schema = null, ?string $exception = null): void
    {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        $actual = $this->serializer->deserialize($json, Server::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    public static function deserializeDataProvider(): iterable
    {
        yield 'Official example #1: A single server would be described as' => [
            'json' => '{
                "url": "https://development.gigantic-server.com/v1",
                "description": "Development server"
            }',
            'schema' => new Server(
                url: 'https://development.gigantic-server.com/v1',
                description: 'Development server',
            ),
        ];

        yield 'Official example #2: With server vars' => [
            'json' => '{
                "url": "https://{username}.gigantic-server.com:{port}/{basePath}",
                "description": "The production API server",
                "variables": {
                    "username": {
                        "default": "demo",
                        "description": "this value is assigned by the service provider, in this example `gigantic-server.com`"
                    },
                    "port": {
                        "enum": [
                            "8443",
                            "443"
                        ],
                        "default": "8443"
                    },
                    "basePath": {
                        "default": "v2"
                    }
                }
            }',
            'schema' => new Server(
                url: 'https://{username}.gigantic-server.com:{port}/{basePath}',
                description: 'The production API server',
                variables: ServerVariablesMap::fromArray([
                    'username' => new ServerVariable(
                        default: 'demo',
                        description: 'this value is assigned by the service provider, in this example `gigantic-server.com`',
                    ),
                    'port' => new ServerVariable(
                        default: '8443',
                        enum: ['8443', '443'],
                    ),
                    'basePath' => new ServerVariable(
                        default: 'v2',
                    ),
                ]),
            ),
        ];
    }

    #[DataProvider('serializeDataProvider')]
    public function testSerialize(Server $schema, ?string $json = null, ?string $exception = null): void
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
            'schema' => new Server(
                url: 'https://{username}.gigantic-server.com:{port}/{basePath}',
                description: 'The production API server',
                variables: ServerVariablesMap::fromArray([
                    'username' => new ServerVariable(
                        default: 'demo',
                        description: 'this value is assigned by the service provider, in this example `gigantic-server.com`',
                    ),
                    'port' => new ServerVariable(
                        default: '8443',
                        enum: ['8443', '443'],
                    ),
                    'basePath' => new ServerVariable(
                        default: 'v2',
                    ),
                ]),
            ),
            'json' => '{
                "url": "https://{username}.gigantic-server.com:{port}/{basePath}",
                "description": "The production API server",
                "variables": {
                    "username": {
                        "default": "demo",
                        "description": "this value is assigned by the service provider, in this example `gigantic-server.com`"
                    },
                    "port": {
                        "enum": [
                            "8443",
                            "443"
                        ],
                        "default": "8443"
                    },
                    "basePath": {
                        "default": "v2"
                    }
                }
            }',
        ];
    }
}