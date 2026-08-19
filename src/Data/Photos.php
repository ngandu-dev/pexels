<?php

declare(strict_types=1);

namespace Ngandu\Pexels\Data;

use Symfony\Component\Serializer\Attribute\Ignore;

/**
 * class Photos.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 * @template T
 * @psalm-template T
 */
final class Photos
{
    use PageableTrait;

    /**
     * @var array<T> An array of Photo objects.
     */
    #[Ignore]
    public array $photos = [];
}
