<?php

declare(strict_types=1);

namespace Ngandu\Pexels\Tests\Parameter;

use InvalidArgumentException;
use Ngandu\Pexels\Parameter\PaginationParameters;
use PHPUnit\Framework\TestCase;

/**
 * Class PaginationParametersTest.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
final class PaginationParametersTest extends TestCase
{
    public function testConstructorWithValidParameters(): void
    {
        // Test case: Valid parameters provided
        $page = 2;
        $perPage = 20;

        $parameters = new PaginationParameters($page, $perPage);

        // Assertions for constructor with valid parameters
        $this->assertEquals($page, $parameters->page);
        $this->assertEquals($perPage, $parameters->per_page);
    }

    public function testConstructorWithInvalidPerPage(): void
    {
        // Test case: Invalid per_page parameter provided
        $invalidPerPage = 10;

        $this->expectException(InvalidArgumentException::class);
        new PaginationParameters(1, $invalidPerPage);
    }

    public function testConstructorWithNegativeValues(): void
    {
        // Test case: Negative values provided for page and per_page
        $negativePage = -1;
        $negativePerPage = -5;

        $this->expectException(InvalidArgumentException::class);
        new PaginationParameters($negativePage, $negativePerPage);
    }

    public function testToArrayMethod(): void
    {
        // Test case: Valid parameters provided
        $page = 2;
        $perPage = 20;

        $parameters = new PaginationParameters($page, $perPage);
        $resultArray = $parameters->toArray();

        // Assertions for toArray() method
        $this->assertArrayHasKey('page', $resultArray);
        $this->assertArrayHasKey('per_page', $resultArray);

        // Verify that null values are filtered out
        $this->assertArrayNotHasKey('per_page', array_filter($resultArray, fn ($p): bool => $p === null));
    }
}
