<?php

declare(strict_types=1);

namespace Ngandu\Pexels\Data;

use Ngandu\Pexels\MappableTrait;

/**
 * class VideoPicture.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
final class VideoPicture
{
    use MappableTrait;

    /**
     * @var int The id of the video_picture.
     */
    public int $id;

    /**
     * @var string A link to the preview image.
     */
    public string $picture;

    public int $nr;
}
