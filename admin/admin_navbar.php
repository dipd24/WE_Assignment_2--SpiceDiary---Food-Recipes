<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">Admin Panel</a>

        <div class="ms-auto text-white">
            Welcome, <?php echo $_SESSION['admin_name']; ?>
            <a href="logout.php" class="btn btn-sm btn-danger ms-3">Logout</a>
        </div>
    </div>
</nav>