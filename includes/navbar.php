<?php
// Current page detect
$current_page = basename($_SERVER['PHP_SELF']); 
?>

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top" style="background-color: #5ca33bf7;">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="index.php">🥘SpiceDiary</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="index.php" class="nav-link fw-bold <?php echo ($current_page=='index.php') ? 'active' : ''; ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a href="about.php" class="nav-link fw-bold <?php echo ($current_page=='about.php') ? 'active' : ''; ?>">About Us</a>
                </li>
                <li class="nav-item">
                    <a href="contact.php" class="nav-link fw-bold <?php echo ($current_page=='contact.php') ? 'active' : ''; ?>">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a href="admin/login.php" target="blank" class="nav-link fw-bold <?php echo ($current_page=='login.php') ? 'active' : ''; ?>">Admin Corner</a>
                </li>
            </ul>
        </div>
    </div>
</nav>