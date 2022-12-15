<?php 

$dbServername = "localhost";
$dbUsername = "mananrajhackovid_db";
$dbPassword = "mananrajhackovid_db";
$dbName = "mananrajhackovid_db";

// create connection
$conn = new mysqli($dbServername,$dbUsername,$dbPassword,$dbName);
// check connection
if($conn -> connect_error) {
    die("connection failed:".$conn->connect_error);
}

$url = 'https://hackovid.mananraj.in';?>