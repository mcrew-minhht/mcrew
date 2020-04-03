<?php
namespace App;
class Constants
{
    const USER_ROLE_ADMIN = 1;
    const USER_ROLE_MEMBER = 2;

    const AUTHORIZE_ADMIN = 'auth:'.self::USER_ROLE_ADMIN;
    
    const WT_TARGET_0 = 0;
    const WT_TARGET_1 = 1;

    const WEEKDAYS_GROUP = [
        0 => 'Sunday',
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
    ];

    const MONTHS_GROUP = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];

    // salary
    const LUNCH_VALUE = 730000;
    const BHXH = 8/100;
    const BHYT = 1.5/100;
    const BHTN = 1/100;
    const BH_TOTAL = 10.5/100;
    const DEPENDENT_PERSON = 3600000;
 
}