<?php

declare(strict_types=1);

namespace Ngandu\Pexels\Data;

use Ngandu\Pexels\MappableTrait;

/**
 * class PhotoSource.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
final class PhotoSource
{
    use MappableTrait;

    /**
     * @var string The image without any size changes. It will be the same as the width and height attributes.
     */
    public string $original;

    /**
     * @var string The image resized to W 940px X H 650px DPR 1.
     */
    public string $large;

    /**
     * @var string The image resized W 940px X H 650px DPR 2.
     */
    public string $large2x;

    /**
     * @var string The image scaled proportionally so that it's new height is 350px.
     */
    public string $medium;

    /**
     * @var string The image scaled proportionally so that it's new height is 130px.
     */
    public string $small;

    /**
     * @var string The image cropped to W 800px X H 1200px.
     */
    public string $portrait;

    /**
     * @var string The image cropped to W 1200px X H 627px.
     */
    public string $landscape;

    /**
     * @var string The image cropped to W 280px X H 200px.
     */
    public string $tiny;
}
