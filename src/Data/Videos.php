<?php

declare(strict_types=1);

namespace Ngandu\Pexels\Data;

use Symfony\Component\Serializer\Attribute\Ignore;

/**
 * class Videos.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 * @template T
 * @psalm-template T
 */
final class Videos
{
    use PageableTrait;

    /**
     * @var string|null The Pexels URL for the current page.
     */
    public ?string $url = null;

    /**
     * @var array<T>
     */
    #[Ignore]
    public array $videos = [];
}
