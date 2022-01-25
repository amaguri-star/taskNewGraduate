<?php

use Carbon\Carbon;

function changeDateformat($date, $date_format)
{
    return Carbon::parse($date)->isoFormat($date_format);
}
