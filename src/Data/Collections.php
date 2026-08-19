<?php

declare(strict_types=1);

namespace Ngandu\Pexels\Data;

use Symfony\Component\Serializer\Attribute\Ignore;

/**
 * class Collections.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 * @template T
 * @psalm-template T
 */
final class Collections
{
    use PageableTrait;

    /**
     * @var array<T>
     */
    #[Ignore]
    public array $collections = [];
}
