<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Urgency extends Enum
{
    const Low =   'faible';
    const Medium =   'modérée';
    const Hight = 'élevée';
    public static $allUrgencies = [self::Low, self::Medium, self::Hight];
}
