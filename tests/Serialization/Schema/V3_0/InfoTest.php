<?php

declare(strict_types=1);

namespace DeadMansSwitch\OpenApi\Tests\Serialization\Schema\V3_0;

use DeadMansSwitch\OpenApi\Schema\V3_0\Contact;
use DeadMansSwitch\OpenApi\Schema\V3_0\Info;
use DeadMansSwitch\OpenApi\Schema\V3_0\License;
use DeadMansSwitch\OpenApi\Serializer\SerializerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

#[CoversNothing]
final class InfoTest extends TestCase
{
    private SerializerInterface $serializer;

    protected function setUp(): void
    {
        $this->serializer = SerializerFactory::create();
    }

    #[DataProvider('data')]
    public function testDeserialize(string $json, Info $schema): void
    {
        $actual = $this->serializer->deserialize($json, Info::class, 'json');

        $this->assertEquals($schema, $actual);
    }

    #[DataProvider('data')]
    public function testSerialize(string $json, Info $schema): void
    {
        $actual = $this->serializer->serialize($schema, 'json');

        $this->assertJsonStringEqualsJsonString($json, $actual);
    }

    public static function data(): iterable
    {
        yield 'Full Info object' => [
            'json' => '{
                "title": "Sample Pet Store App",
                "summary": "A pet store manager.",
                "description": "This is a sample server for a pet store.",
                "termsOfService": "https://example.com/terms/",
                "contact": {
                    "name": "API Support",
                    "url": "https://www.example.com/support",
                    "email": "support@example.com"
                },
                "license": {
                    "name": "Apache 2.0",
                    "url": "https://www.apache.org/licenses/LICENSE-2.0.html"
                },
                "version": "1.0.1"
            }',
            'schema' => new Info(
                title: 'Sample Pet Store App',
                version: '1.0.1',
                summary: 'A pet store manager.',
                description: 'This is a sample server for a pet store.',
                termsOfService: 'https://example.com/terms/',
                contact: new Contact(
                    name: 'API Support',
                    url: 'https://www.example.com/support',
                    email: 'support@example.com',
                ),
                license: new License(
                    name: 'Apache 2.0',
                    url: 'https://www.apache.org/licenses/LICENSE-2.0.html',
                ),
            ),
        ];
    }
}