<?php
require __DIR__.'/vendor/autoload.php';
use Carbon\Carbon;
$now = Carbon::now()->locale('id');
echo $now->dayName . ', ' . $now->day . ' ' . $now->monthName . ' ' . $now->year;
?>