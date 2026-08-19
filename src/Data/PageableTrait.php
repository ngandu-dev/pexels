<?php

declare(strict_types=1);

namespace Ngandu\Pexels\Data;

/**
 * trait PageableTrait.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
trait PageableTrait
{
    /**
     * @var int The current page number.
     */
    public int $page = 1;

    /**
     * @var int The number of results returned with each page.
     */
    public int $per_page = 15;

    /**
     * @var int|null The total number of results for the request.
     */
    public ?int $total_results = null;

    /**
     * @var string|null URL for the previous page of results, if applicable.
     */
    public ?string $next_page = null;

    /**
     * @var string|null URL for the next page of results, if applicable.
     */
    public ?string $prev_page = null;
}
