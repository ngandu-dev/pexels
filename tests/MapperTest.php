<?php

declare(strict_types=1);

namespace Ngandu\Pexels\Tests;

use Ngandu\Pexels\Mapper;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * Class MapperTest.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
final class MapperTest extends TestCase
{
    public function testToObjectMethod(): void
    {
        // Test case: Test toObject method
        $data = [
            'name' => 'John',
            'age' => 30,
        ];
        $object = new stdClass();

        /** @var stdClass&object{name: string, age: int} $resultObject */
        $resultObject = Mapper::toObject($object, $data);

        // Assertions for toObject() method
        $this->assertInstanceOf(stdClass::class, $resultObject);
        $this->assertEquals('John', $resultObject->name);
        $this->assertEquals(30, $resultObject->age);
    }

    public function testToArrayMethod(): void
    {
        // Test case: Test toArray method
        $data = new class() {
            public string $name;

            public int $age;
        };
        $data->name = 'Alice';
        $data->age = 25;

        $resultArray = Mapper::toArray([], $data);

        // Assertions for toArray() method
        $this->assertArrayHasKey('name', $resultArray);
        $this->assertEquals('Alice', $resultArray['name']);
        $this->assertArrayHasKey('age', $resultArray);
        $this->assertEquals(25, $resultArray['age']);
    }
}
