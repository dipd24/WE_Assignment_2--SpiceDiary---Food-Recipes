<?php
$conn = mysqli_connect("localhost", "root", "", "foodblog_database");
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>
