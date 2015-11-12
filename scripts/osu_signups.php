<?php
/*
This script will run every minute, and find all the users at OSU. It
will write their email addresses to a file, but only if they aren't
in the file already. Hacky and brute-force, but the shema doesn't allow
many elegant ways to do this.
*/

// define all the things
$user_name = "";
$password = "";
$database = "";
$server = "localhost";
$filename = "osu_users";

// define the database connection
$connect = mysql_connect($server, $user_name, $password) or die(mysql_error());

// connect to the database
mysql_select_db($database,$connect) or die(mysql_error());

// define the SQL query (why on earth is school a string and not a foreign
// key?) Anyway, we only want the email here for anyone at OSU
$query = "SELECT email FROM users WHERE school='Oregon State University'";

// execute the query, store results as an array
$osu_users = mysql_query($query) or die(mysql_error());

// open the file for appending
$file = fopen($filename, 'a+');

// read the existing file into an array, leaving off the newlines
$unique_users = file($filename, FILE_IGNORE_NEW_LINES);

// iterate through the fetched rows
while($osu_user = mysql_fetch_array($osu_users)){

    // if the user in the row already has their email in the file
    // then we don't want to write it again
    if(!in_array($osu_user['email'], $unique_users)) {
	// write this row's email address to the file
        fwrite($file, $osu_user['email'] . "\n");
    } 
}

// close the file
fclose($file)	
?>
