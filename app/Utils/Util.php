<?php

function getPrevMonth()
{
    $currentDate = new DateTime();

    $currentDate->sub(new DateInterval('P1M'));

    $prevMonth = $currentDate->format('Y-m');

    return $prevMonth;
}
