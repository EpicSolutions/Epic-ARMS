<?php 
// Created BY Sean Malone - 12/31/2010 
/* 
1: "die()" will exit the script and show an error statement if something goes wrong with the "connect" or "select" functions. 
2: A "mysql_connect()" error usually means your username/password are wrong 
3: A "mysql_select_db()" error usually means the database does not exist.
*/
// Place db host name. Sometimes "localhost" but 
// sometimes looks like this: >>      ???mysql??.someserver.net
$db_host = "localhost";
// Place the username for the MySQL database here
$db_username = "esiadmin_arms"; 
// Place the password for the MySQL database here
$db_pass = "1qazXSW@"; 
// Place the name for the MySQL database here
$db_name = "esiadmin_arms";

// Run the actual connection here 
mysql_connect("$db_host","$db_username","$db_pass") or die ("could not connect to mysql");
mysql_select_db("$db_name") or die ("no database");             
?>