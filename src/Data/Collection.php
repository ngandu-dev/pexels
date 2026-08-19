<?php

declare(strict_types=1);

namespace Ngandu\Pexels\Data;

use Ngandu\Pexels\MappableTrait;

/**
 * class Collection.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
final class Collection
{
    use MappableTrait;

    /**
     * @var string The id of the collection.
     */
    public string $id;

    /**
     * @var string The name of the collection.
     */
    public string $title;

    /**
     * @var string|null The description of the collection.
     */
    public ?string $description = null;

    /**
     * @var bool Whether or not the collection is marked as private.
     */
    public bool $private = true;

    /**
     * @var int The total number of media included in this collection.
     */
    public int $media_count = 0;

    /**
     * @var int The total number of photos included in this collection.
     */
    public int $photos_count = 0;

    /**
     * @var int The total number of videos included in this collection.
     */
    public int $videos_count = 0;
}
