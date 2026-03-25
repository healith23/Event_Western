<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "event_western";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
