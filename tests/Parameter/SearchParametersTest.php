<?php

declare(strict_types=1);

namespace Ngandu\Pexels\Tests\Parameter;

use InvalidArgumentException;
use Ngandu\Pexels\Parameter\SearchParameters;
use PHPUnit\Framework\TestCase;

/**
 * Class SearchParametersTest.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
final class SearchParametersTest extends TestCase
{
    public function testValidParameters(): void
    {
        // Test case: Valid parameters provided
        $orientation = 'landscape';
        $size = 'large';
        $color = 'blue';
        $locale = 'en-US';
        $page = 2;
        $perPage = 20;

        $searchParams = new SearchParameters($orientation, $size, $color, $locale, $page, $perPage);

        // Assertions for constructor with valid parameters
        $this->assertEquals($orientation, $searchParams->orientation);
        $this->assertEquals($size, $searchParams->size);
        $this->assertEquals($color, $searchParams->color);
        $this->assertEquals($locale, $searchParams->locale);
        $this->assertEquals($page, $searchParams->page);
        $this->assertEquals($perPage, $searchParams->per_page);
    }

    public function testInvalidOrientationParameter(): void
    {
        // Test case: Invalid orientation parameter provided
        $invalidOrientation = 'invalid_orientation';

        $this->expectException(InvalidArgumentException::class);
        new SearchParameters($invalidOrientation, null, null, null, 1, 15);
    }

    public function testInvalidSizeParameter(): void
    {
        // Test case: Invalid size parameter provided
        $invalidSize = 'invalid_size';

        $this->expectException(InvalidArgumentException::class);
        new SearchParameters(null, $invalidSize, null, null, 1, 15);
    }

    public function testInvalidColorParameter(): void
    {
        // Test case: Invalid color parameter provided
        $invalidColor = 'invalid_color';

        $this->expectException(InvalidArgumentException::class);
        new SearchParameters(null, null, $invalidColor, null, 1, 15);
    }

    public function testValidHexColorParameterWithThreeDigits(): void
    {
        $color = '#fff';

        $searchParams = new SearchParameters(null, null, $color, null, 1, 15);

        $this->assertEquals($color, $searchParams->color);
    }

    public function testValidHexColorParameterWithSixDigits(): void
    {
        $color = '#a1B2c3';

        $searchParams = new SearchParameters(null, null, $color, null, 1, 15);

        $this->assertEquals($color, $searchParams->color);
    }

    public function testInvalidHexColorParameter(): void
    {
        $invalidColor = '#12';

        $this->expectException(InvalidArgumentException::class);
        new SearchParameters(null, null, $invalidColor, null, 1, 15);
    }

    public function testToArrayMethod(): void
    {
        // Test case: Valid parameters provided
        $orientation = 'landscape';
        $size = 'large';
        $color = 'blue';
        $locale = 'en-US';
        $page = 2;
        $perPage = 20;

        $searchParams = new SearchParameters($orientation, $size, $color, $locale, $page, $perPage);
        $resultArray = $searchParams->toArray();

        // Assertions for toArray() method
        $this->assertArrayHasKey('orientation', $resultArray);
        $this->assertArrayHasKey('size', $resultArray);
        $this->assertArrayHasKey('color', $resultArray);
        $this->assertArrayHasKey('locale', $resultArray);
        $this->assertArrayHasKey('page', $resultArray);
        $this->assertArrayHasKey('per_page', $resultArray);

        // Verify that null values are filtered out
        $this->assertArrayNotHasKey('color', array_filter($resultArray, fn ($p): bool => $p === null));
    }
}
