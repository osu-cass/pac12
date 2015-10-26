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

// get the current day's date
$currentDate = date('Y-m-d');

// open file for appending
$file = fopen($filename, 'a+');

// read the existing file into an array, leave off the newlines
$user_found = file($filename, FILE_IGNORE_NEW_LINES);
$found_emails = array();

// get array of users already in the file
foreach($user_found as $found_user) {
    $pieces = explode(" ", $found_user);
    $found_emails[] = $pieces[0];
}

// define db connection
$connect = mysql_connect($server, $user_name, $password) or die(mysql_error());

// connect to db
mysql_select_db($database, $connect) or die(mysql_error());

// define SQL query - get minutes and join user table for OSU participants
$query = "SELECT user_id, minutes, email FROM times JOIN users on users.id WHERE times.school = 'Oregon State University' AND users.id=times.user_id AND times.date <= '$currentDate'";
 
// execute query and store the results into an array
$osu_users = mysql_query($query) or die(mysql_error());

// construct an array of unique users and their total minutes
$users = array();
while ($osu_user = mysql_fetch_array($osu_users)){
    if(array_key_exists($osu_user['email'], $users )) {
        $users[$osu_user['email']] += $osu_user['minutes'];
    } else {
        $users[$osu_user['email']] = $osu_user['minutes'];
    }
}

// get date and time when user was found
$getdate = date_create();
$date = date_format($getdate, 'Y-m-d H:i:s');

// write all our unique 200 minute users to the file if they aren't in 
// there already
foreach($users as $email=>$minutes) {
    if ($minutes >= 200) {
	    if (!in_array($email, $found_emails)) {
    	    fwrite($file, $email . " $minutes minutes at $date \n");
	    }
    } 
}	
