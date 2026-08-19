<?php

declare(strict_types=1);

namespace Ngandu\Pexels\Parameter;

use Ngandu\Pexels\Mapper;
use Override;
use Webmozart\Assert\Assert;

/**
 * class PopularVideosParameters.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
final class PopularVideosParameters extends Parameters
{
    /**
     * @var int|null The minimum width in pixels of the returned videos.
     */
    public readonly ?int $min_width;

    /**
     * @var int|null The minimum height in pixels of the returned videos.
     */
    public readonly ?int $min_height;

    /**
     * @var int|null The minimum duration in seconds of the returned videos.
     */
    public readonly ?int $min_duration;

    /**
     * @var int|null The maximum duration in seconds of the returned videos.
     */
    public readonly ?int $max_duration;

    public function __construct(
        ?int $min_width = null,
        ?int $min_height = null,
        ?int $min_duration = null,
        ?int $max_duration = null,
        int $page = 1,
        int $per_page = 15
    ) {
        parent::__construct($page, $per_page);
        Assert::nullOrGreaterThan($min_duration, 1);
        Assert::nullOrGreaterThan($max_duration, 1);
        Assert::nullOrGreaterThan($min_width, 1);
        Assert::nullOrGreaterThan($min_height, 1);

        $this->min_width = $min_width;
        $this->min_height = $min_height;
        $this->min_duration = $min_duration;
        $this->max_duration = $max_duration;
    }

    #[Override]
    public function toArray(): array
    {
        return array_filter(Mapper::toArray([], $this), fn ($p): bool => $p !== null);
    }
}
