<?php

namespace App\Helpers;

class GeneralHelper
{
    /**
     * @param int $monthNumber
     * @return array
     */
    public static function monthString(int $monthNumber): string
    {
        return self::monthsNames()[$monthNumber - 1];
    }

    public static function monthsNames(): array
    {
        return [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'Dicember'
        ];
    }
}
