<?php
require __DIR__.'/vendor/autoload.php';
use Carbon\Carbon;
$now = Carbon::now();
$fmt = new IntlDateFormatter('id_ID', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
echo $fmt->format($now);
?>