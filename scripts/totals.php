<?php
/*
This script will run every minute to total the times of OSU users and
write the email address of the users who have reached 200 minutes
*/

// define things
$user_name = "";
$password = "";
$database = "";
$server = "localhost";
$filename = "osu_200";

// set the timezone
date_default_timezone_set('America/Los_Angeles');


// define db connection
$connect = mysql_connect($server, $user_name, $password) or die(mysql_error());

// connect to db
mysql_select_db($database, $connect) or die(mysql_error());

// define SQL query - get minutes and join user table for OSU participants
$query = "SELECT sum(minutes) as total, school, count( distinct user_id) as students, id FROM `times` group by school;";

// execute query and store the results into an array
$totals = mysql_query($query) or die(mysql_error());

// construct an array of unique users and their total minutes
$users = array();
while ($total = mysql_fetch_array($totals)){
    print_r($total);
    $new_query = "UPDATE totals SET minutes=".$total['total'].", students=".$total['students']." WHERE school='".$total['school']."';";
    mysql_query($new_query) or die(mysql_error());

}


