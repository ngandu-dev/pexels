<?php

declare(strict_types=1);

namespace Ngandu\Pexels\Data;

use Ngandu\Pexels\MappableTrait;

/**
 * class VideoFile.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
final class VideoFile
{
    use MappableTrait;

    /**
     * @var int The id of the video_file.
     */
    public int $id;

    /**
     * @var string 'hd' or 'sd' The video quality of the video_file.
     */
    public string $quality;

    /**
     * @var string The video format of the video_file.
     */
    public string $file_type;

    /**
     * @var int|null The width of the video_file in pixels
     */
    public ?int $width = null;

    /**
     * @var int|null The height of the video_file in pixels
     */
    public ?int $height = null;

    /**
     * @var string  link to where the video_file is hosted.
     */
    public string $link;

    /**
     * @var float|null frame rate of the video_file.
     */
    public ?float $fps = null;
}
