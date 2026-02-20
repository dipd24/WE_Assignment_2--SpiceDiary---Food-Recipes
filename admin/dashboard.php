<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Count Data
$post_count = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM posts"));
$category_count = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM categories"));
$comment_count = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM comments"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - SpiceDiary</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">🥘SpiceDiary Admin</a>

        <div class="ms-auto text-white">
            Welcome, <?php echo $_SESSION['admin_name']; ?>
            <a href="logout.php" class="btn btn-sm btn-danger ms-3">Logout</a>
            <a href="../index.php" target="blank" class="btn btn-sm btn-secondary ms-3">HomePage</a>

        </div>
    </div>
</nav>

<div class="container mt-5">

    <h2 class="mb-4">Dashboard Overview</h2>

    <!-- Stats Cards -->
    <div class="row g-4">

        <div class="col-md-4">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <h5>Total Posts</h5>
                    <h2 class="fw-bold text-primary">
                        <?php echo $post_count; ?>
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <h5>Total Categories</h5>
                    <h2 class="fw-bold text-success">
                        <?php echo $category_count; ?>
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <h5>Total Comments</h5>
                    <h2 class="fw-bold text-danger">
                        <?php echo $comment_count; ?>
                    </h2>
                </div>
            </div>
        </div>

    </div>

    <hr class="my-5">

    <!-- Quick Action Buttons -->
    <div class="row g-3">

        <div class="col-md-3">
            <a href="add_post.php" class="btn btn-success w-100">
                Add New Post
            </a>
        </div>

        <div class="col-md-3">
            <a href="manage_posts.php" class="btn btn-primary w-100">
                Manage Posts
            </a>
        </div>

        <div class="col-md-3">
            <a href="manage_categories.php" class="btn btn-info w-100">
                Manage Categories
            </a>
        </div>

        <div class="col-md-3">
            <a href="manage_comments.php" class="btn btn-dark w-100">
                Manage Comments
            </a>
        </div>
        <div class="mx-auto col-md-3">
            <a href="manage_contacts.php" class="btn btn-warning w-100">
                Manage Contact Messages
            </a>
        </div>

    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>