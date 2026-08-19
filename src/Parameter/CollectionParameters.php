<?php

declare(strict_types=1);

namespace Ngandu\Pexels\Parameter;

use Webmozart\Assert\Assert;

/**
 * class CollectionParameters.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
final class CollectionParameters extends Parameters
{
    /**
     * @var string|null
     *
     * The type of media you are requesting.
     * If not given or if given with an invalid value, all media will be returned.
     * Supported values are photos and videos.
     */
    public readonly ?string $type;

    /**
     * @var string
     *
     * The order of items in the media collection. Supported values are: asc, desc. Default: asc
     */
    public readonly string $sort;

    public function __construct(?string $type = null, int $page = 1, int $per_page = 15, string $sort = 'asc')
    {
        parent::__construct($page, $per_page);
        Assert::nullOrOneOf($type, ['photos', 'videos']);
        Assert::nullOrOneOf($sort, ['asc', 'desc']);

        $this->type = $type;
        $this->sort = $sort;
    }
}
