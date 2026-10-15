<?php
require __DIR__.'/vendor/autoload.php';
use Carbon\Carbon;
$now = Carbon::now();
echo $now->locale('id')->format('d-m-Y');
?>