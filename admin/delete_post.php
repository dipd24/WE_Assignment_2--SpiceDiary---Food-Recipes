<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM posts WHERE id=$id");

header("Location: manage_posts.php");
exit();
?>