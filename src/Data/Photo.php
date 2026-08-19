<?php

declare(strict_types=1);

namespace Ngandu\Pexels\Data;

use Ngandu\Pexels\MappableTrait;

/**
 * class Photo.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
final class Photo extends Resource
{
    use MappableTrait;

    /**
     * @var string The name of the photographer who took the photo.
     */
    public string $photographer;

    /**
     * @var string The URL of the photographer's Pexels profile.
     */
    public string $photographer_url;

    /**
     * @var int The id of the photographer.
     */
    public int $photographer_id;

    /**
     * @var string The average color of the photo. Useful for a placeholder while the image loads.
     */
    public string $avg_color;

    /**
     * @var string Text description of the photo for use in the alt attribute.
     */
    public string $alt;

    /**
     * @var PhotoSource An assortment of different image sizes that can be used to display this Photo.
     */
    public PhotoSource $src;

    public bool $liked = false;

    public function setSrc(array $source): void
    {
        $this->src = PhotoSource::fromArray($source);
    }
}
