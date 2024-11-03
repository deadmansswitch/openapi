<?php

namespace DeadMansSwitch\OpenApi\Tests\Unit\Types;

use Exception;
use DeadMansSwitch\OpenApi\Types\MapOfStrings;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(className: MapOfStrings::class)]
final class MapOfStringsTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testGetIterator(): void
    {
        $items = [
            'foo' => 'bar',
            'baz' => 'qux',
        ];

        $map = MapOfStrings::fromArray($items);

        $this->assertInstanceOf('Traversable', $map->getIterator());
        $this->assertSame('bar', $map['foo']);
        $this->assertSame('qux', $map['baz']);
    }
}
