<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Gender extends Enum
{
    const Man = 'homme';
    const Woman = 'femme';
    const Other = 'autre';
    public static $allGenders = [self::Man, self::Woman, self::Other];
}
