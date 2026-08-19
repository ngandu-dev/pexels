<?php

declare(strict_types=1);

namespace Ngandu\Pexels\Parameter;

use Ngandu\Pexels\Mapper;
use Webmozart\Assert\Assert;

/**
 * class Parameters.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
abstract class Parameters
{
    /**
     * @var int The current page number.
     */
    public readonly int $page;

    /**
     * @var int The number of results returned with each page.
     */
    public readonly int $per_page;

    public function __construct(int $page = 1, int $per_page = 15)
    {
        Assert::greaterThanEq($page, 1);
        Assert::lessThanEq($per_page, 80);
        Assert::greaterThanEq($per_page, 15);

        $this->page = $page;
        $this->per_page = $per_page;
    }

    public function toArray(): array
    {
        return array_filter(Mapper::toArray([], $this), fn ($p): bool => $p !== null);
    }
}
