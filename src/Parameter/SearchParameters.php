<?php

declare(strict_types=1);

namespace Ngandu\Pexels\Parameter;

use Webmozart\Assert\Assert;

/**
 * class SearchParameters.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
final class SearchParameters extends Parameters
{
    public readonly ?string $orientation;

    public readonly ?string $size;

    public readonly ?string $color;

    public readonly ?string $locale;

    /**
     * @param string|null $orientation Desired photo orientation.
     * The current supported orientations are: landscape, portrait or square.
     *
     * @param string|null $size Minimum photo size.
     * The current supported sizes are: large(24MP), medium(12MP) or small(4MP).
     *
     * @param string|null $color Desired photo color.
     * Supported colors: red, orange, yellow, green, turquoise, blue, violet, pink, brown,
     * black, gray, white or any hexadecimal color code (eg. #ffffff).
     *
     * @param string|null $locale The locale of the search you are performing.
     * The current supported locales are: 'en-US' 'pt-BR' 'es-ES' 'ca-ES' 'de-DE' 'it-IT' 'fr-FR' 'sv-SE'
     * 'id-ID' 'pl-PL' 'ja-JP' 'zh-TW' 'zh-CN' 'ko-KR' 'th-TH' 'nl-NL' 'hu-HU' 'vi-VN' 'cs-CZ' 'da-DK'
     * 'fi-FI' 'uk-UA' 'el-GR' 'ro-RO' 'nb-NO' 'sk-SK' 'tr-TR' 'ru-RU'.
     *
     * @param int $page ;
     * @param int $per_page ;
     **/
    public function __construct(
        ?string $orientation = null,
        ?string $size = null,
        ?string $color = null,
        ?string $locale = 'en-US',
        int $page = 1,
        int $per_page = 15
    ) {
        parent::__construct($page, $per_page);
        Assert::nullOrOneOf($orientation, ['landscape', 'portrait', 'square']);
        Assert::nullOrOneOf($size, ['large', 'medium', 'small']);

        if ($color !== null) {
            $supportedColors = [
                'red' => true,
                'orange' => true,
                'yellow' => true,
                'green' => true,
                'turquoise' => true,
                'blue' => true,
                'violet' => true,
                'pink' => true,
                'brown' => true,
                'black' => true,
                'gray' => true,
                'white' => true,
            ];

            if (! isset($supportedColors[$color])) {
                Assert::regex($color, '/^#(?:[A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/', 'Invalid color.');
            }
        }

        Assert::nullOrOneOf($locale, ['en-US', 'pt-BR', 'es-ES', 'ca-ES', 'de-DE', 'it-IT', 'fr-FR', 'sv-SE', 'id-ID', 'pl-PL', 'ja-JP', 'zh-TW', 'zh-CN', 'ko-KR', 'th-TH', 'nl-NL', 'hu-HU', 'vi-VN', 'cs-CZ', 'da-DK', 'fi-FI', 'uk-UA', 'el-GR', 'ro-RO', 'nb-NO', 'sk-SK', 'tr-TR', 'ru-RU']);

        $this->orientation = $orientation;
        $this->size = $size;
        $this->color = $color;
        $this->locale = $locale;
    }
}
