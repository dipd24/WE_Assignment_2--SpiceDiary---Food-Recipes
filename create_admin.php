<?php
include 'includes/db.php';

$name = "Admin";
$email = "admin@gmail.com";
$password = password_hash("123456", PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, email, password)
        VALUES ('$name', '$email', '$password')";

if (mysqli_query($conn, $sql)) {
    echo "Admin Created Successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>