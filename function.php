<?php
require_once('vendor/autoload.php');
require_once('class/carbonDateTime.php');

$fs_config = array();
$fs_config["DEFINE"]["TIMEZONE"] = "Australia/Brisbane";

//Object
$objDateTime = new carbonDateTime($fs_config);


//Event Details:
$event_tz = 'Asia/Kathmandu'; //Timezone
$event_current_dt = $objDateTime->getCurrentDateTime($event_tz);  //Current Date and time
$event_offset = $objDateTime->getTimezoneOffset($event_tz); //UTC Offset
$event_close_date = '2017-04-24 07:45'; //Event close date


//Server parameters
$server_tz = $objDateTime->getTimezone(); //Timezone
$server_current_dt = $objDateTime->getCurrentDateTime(); //Current Date and time
$server_offset = $objDateTime->getTimezoneOffset($server_tz); //UTC Offset


//Conversion to server timezone
$event_close_date_server = $objDateTime->convertToServerTz($event_close_date, $event_tz);


//Differences
$time_diff_server = $objDateTime->getDateDiff($server_current_dt, $event_close_date_server,"seconds");
$human_readable_diff_server = $objDateTime->seconds2human($time_diff_server);
