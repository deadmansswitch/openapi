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

$serializer = \DeadMansSwitch\OpenApi\Serializer\SerializerFactory::create();
$OpenApi    = $serializer->deserialize(
    data: $json,
    type: \DeadMansSwitch\OpenApi\Schema\V3_0\OpenApi::class,
    format: 'json',
);

print_r($OpenApi);
exit(0);

```

PHP -> JSON:

```php 

$OpenApi = new \DeadMansSwitch\OpenApi\Schema\V3_0\OpenApi(
    OpenApi: '3.0.0',
    info: new \DeadMansSwitch\OpenApi\Schema\V3_0\Info(
        title: 'Sample API',
        version: '1.0.0',
    ),
    paths: \DeadMansSwitch\OpenApi\Schema\V3_0\Paths::fromArray([
        '/' => new \DeadMansSwitch\OpenApi\Schema\V3_0\PathItem(
            get: new \DeadMansSwitch\OpenApi\Schema\V3_0\Operation(
                responses: \DeadMansSwitch\OpenApi\Schema\V3_0\Responses::fromArray([
                    '200' => new \DeadMansSwitch\OpenApi\Schema\V3_0\Response(
                        description: 'OK',
                    ),
                ]),
            ),
        ),
    ]),
);

$serializer = \DeadMansSwitch\OpenApi\Serializer\SerializerFactory::create();
$json       = $serializer->serialize(
    data: $openapi,
    format: 'json',
);

print_r($json);
exit(0);

```

### Things that are not supported
- `oneOf`, `anyOf`, `allOf`