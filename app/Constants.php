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

 
}