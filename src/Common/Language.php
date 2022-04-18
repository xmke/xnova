<?php

declare(strict_types=1);

namespace Xmke\Xnova\Common;

class Language
{
    public const FRENCH = 'fr';
    public const ENGLISH = 'en';
    public const ITALIAN = 'it';

    public const LANGUAGES = [
        self::ENGLISH,
        self::FRENCH,
        self::ITALIAN
    ];

    public const DEFAULT_LANGUAGE = self::ENGLISH;

}