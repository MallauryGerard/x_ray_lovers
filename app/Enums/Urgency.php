<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Urgency extends Enum
{
    const Low =   'faible';
    const Medium =   'modérée';
    const Hight = 'élevée';
}
