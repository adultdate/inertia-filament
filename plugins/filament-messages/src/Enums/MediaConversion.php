<?php

declare(strict_types=1);

namespace Adultdate\FilamentMessages\Enums;

enum MediaConversion: string
{
    case ORIGINAL = 'original';
    case SM = 'small';
    case MD = 'medium';
    case LG = 'large';
}
