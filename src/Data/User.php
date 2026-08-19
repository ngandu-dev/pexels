<?php

declare(strict_types=1);

namespace Ngandu\Pexels\Data;

use Ngandu\Pexels\MappableTrait;

/**
 * class User.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
final class User
{
    use MappableTrait;

    /**
     * @var int The id of the user.
     */
    public int $id;

    /**
     * @var string The name of the user.
     */
    public string $name;

    /**
     * @var string The URL of the user's Pexels profile.
     */
    public string $url;
}
