v0.1.0

This package allows to convert JSON OpenApi schema into PHP Object Representation and vice versa.

JSON -> PHP:

```php

$json = '{
    "openapi": "3.0.0",
    "info": {
        "title": "Sample API",
        "version": "1.0.0"
    },
    "paths": {
        "/": {
            "get": {
                "responses": {
                    "200": {
                        "description": "OK"
                    }
                }
            }
        }
    }
}';

$serializer = \DeadMansSwitch\OpenAPI\Serializer\SerializerFactory::create();
$openapi    = $serializer->deserialize(
    data: $json,
    type: \DeadMansSwitch\OpenAPI\Schema\V3_0\OpenApi::class,
    format: 'json',
);

print_r($openapi);
exit(0);

```

PHP -> JSON:

```php 

$openapi = new \DeadMansSwitch\OpenAPI\Schema\V3_0\OpenApi(
    openapi: '3.0.0',
    info: new \DeadMansSwitch\OpenAPI\Schema\V3_0\Info(
        title: 'Sample API',
        version: '1.0.0',
    ),
    paths: \DeadMansSwitch\OpenAPI\Schema\V3_0\Paths::fromArray([
        '/' => new \DeadMansSwitch\OpenAPI\Schema\V3_0\PathItem(
            get: new \DeadMansSwitch\OpenAPI\Schema\V3_0\Operation(
                responses: \DeadMansSwitch\OpenAPI\Schema\V3_0\Responses::fromArray([
                    '200' => new \DeadMansSwitch\OpenAPI\Schema\V3_0\Response(
                        description: 'OK',
                    ),
                ]),
            ),
        ),
    ]),
);

$serializer = \DeadMansSwitch\OpenAPI\Serializer\SerializerFactory::create();
$json       = $serializer->serialize(
    data: $openapi,
    format: 'json',
);

print_r($json);
exit(0);

```

### Things that are not supported
- `oneOf`, `anyOf`, `allOf`