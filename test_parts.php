<?php
require __DIR__.'/vendor/autoload.php';
use Carbon\Carbon;
$now = Carbon::now()->locale('id');
echo $now->dayOfWeek; // 0-6
echo $now->dayName; //?
echo $now->monthName; //?
echo $now->year;
?>