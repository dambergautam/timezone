<?php
include 'vendor/autoload.php';

use Carbon\Carbon;

//HTML
echo "<title>Timezone -Carbon</title>";
$b = "<br />";
$h = "<hr/>";

$date1 = "2017-04-24 07:45:00";
$date2 = "2017-01:04 12:00:00";

$t1 = Carbon::now();

echo $b;

$t2 = Carbon::now('Asia/Kathmandu');


$date = new DateTime('2000-01-01', new DateTimeZone('Australia/Brisbane'));
echo $date->format('Y-m-d h:i:sP');

echo $b;

$date->setTimezone(new DateTimeZone('Asia/Kathmandu'));
echo $date->format('Y-m-d h:i:sP');

echo $b.$b.$b;

//Function to convert timezone
function convertToTz($event_close_date, $tz, $format='Y-m-d h:i:s P'){

	//date_default_timezone_set('UTC');
	//$date = new DateTime($event_close_date, new DateTimeZone('Australia/Brisbane'));
	$date = new DateTime($event_close_date, new DateTimeZone('Australia/Brisbane'));

	$date->setTimezone(new DateTimeZone($tz));
	//$date->setTimezone(new DateTimeZone('UTC'));
	return $date->format($format);
}

$ecdate = "2017-04-24 07:45:00";
echo $ecdate.$b;
echo convertToTz($ecdate, 'Asia/Kathmandu');

echo $b;

$format = "M d, Y h:ia";
$timestamp = gmdate($format);
date_default_timezone_set("UTC");
$utc_datetime = date($format, $timestamp);
echo $utc_datetime; 

//var_dump( DateTimeZone::listIdentifiers() ); 
?>