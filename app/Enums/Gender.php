<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Gender extends Enum
{
    const Man = 'homme';
    const Woman = 'femme';
    const Other = 'autre';
    public static $allGenders = [self::Man, self::Woman, self::Other];
}
