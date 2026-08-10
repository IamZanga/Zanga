<?php

return [

    /*
    |--------------------------------------------------------------------------
    | School Periods
    |--------------------------------------------------------------------------
    |
    | Fixed, school-wide period structure. Period 0 is always Registration.
    | Periods 1-7 are teaching periods. A break falls between periods 4 and 5,
    | so periods 4 and 5 are never treated as a valid "double" pair.
    |
    */

    'periods' => [
        0 => ['label' => 'Period 0', 'start' => '12:00', 'end' => '12:40'],
        1 => ['label' => 'Period 1', 'start' => '12:40', 'end' => '13:15'],
        2 => ['label' => 'Period 2', 'start' => '13:15', 'end' => '13:50'],
        3 => ['label' => 'Period 3', 'start' => '13:50', 'end' => '14:25'],
        4 => ['label' => 'Period 4', 'start' => '14:25', 'end' => '15:00'],
        5 => ['label' => 'Period 5', 'start' => '15:15', 'end' => '15:50'],
        6 => ['label' => 'Period 6', 'start' => '15:50', 'end' => '16:25'],
        7 => ['label' => 'Period 7', 'start' => '16:25', 'end' => '17:00'],
    ],

    'registration_period' => 0,

    'break_after_period' => 4,

    'days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],

];
