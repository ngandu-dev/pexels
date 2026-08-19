<?php

declare(strict_types=1);

namespace Ngandu\Pexels\Data;

/**
 * class Resource.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
abstract class Resource
{
    /**
     * @var int The id of the resource.
     */
    public int $id;

    /**
     * @var int The real width of the resource in pixels.
     */
    public int $width;

    /**
     * @var int The real height of the resource in pixels.
     */
    public int $height;

    /**
     * @var string The Pexels URL where the resource is located.
     */
    public string $url;

    /**
     * @var string|null The type of the resource. Possible values are photo and video.
     */
    public ?string $type = null;
}
