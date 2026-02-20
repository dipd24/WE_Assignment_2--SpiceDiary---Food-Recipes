<?php
include("includes/db.php");

/* ===============================
   FILTER SECTION LOGIC
=================================*/

// Fetch categories for dropdown
$category_result = mysqli_query($conn, "SELECT * FROM categories ORDER BY category_name ASC");

// Get filter values from URL
$category_filter   = isset($_GET['category']) ? $_GET['category'] : '';
$difficulty_filter = isset($_GET['difficulty']) ? $_GET['difficulty'] : '';
$time_filter       = isset($_GET['time']) ? $_GET['time'] : '';

/* ===============================
   DYNAMIC POSTS QUERY
=================================*/

$query = "
    SELECT posts.*, categories.category_name 
    FROM posts 
    JOIN categories ON posts.category_id = categories.id
    WHERE posts.status='published'
";

if ($category_filter != '') {
    $query .= " AND posts.category_id = '" . mysqli_real_escape_string($conn, $category_filter) . "'";
}

if ($difficulty_filter != '') {
    $query .= " AND posts.difficulty = '" . mysqli_real_escape_string($conn, $difficulty_filter) . "'";
}

if ($time_filter != '') {
    $query .= " AND posts.cooking_time = '" . mysqli_real_escape_string($conn, $time_filter) . "'";
}

$query .= " ORDER BY posts.created_at DESC";

$posts_query = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpiceDiary - Food Recipes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .navbar-nav .nav-link:hover {
            color: #f3c029 !important;
        }

        .card:hover {
            transform: scale(1.03);
            transition: 0.3s;
        }

        footer {
            background: #3d016ef6;
            color: #fff;
            padding: 20px 0;
            margin-top: 50px;
        }

        footer a {
            color: #ffc107;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .hero {
            height: 400px;
            width: 1296px;
            background-image: url(hero_image.png);
            color: #ffffff;
            border-radius: 10px;
            padding: 3rem 2rem;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <?php include("includes/navbar.php"); ?>

    <!-- searchbar -->

    <div class="container mt-3">
        <form method="GET" action="search.php" class="d-flex justify-content-center">
            <input
                type="text"
                name="keyword"
                class="form-control w-50 me-2"
                placeholder="Search recipe by title..."
                required>
            <button class="btn btn-warning">Search</button>
        </form>
    </div>

    <!-- Hero Section -->
    <div class="container mt-3">
        <div id="inter" class="hero shadow-sm ">
            <h1 class="display-4 fw-bold">Delicious Recipes For You...</h1>
            <p class="lead my-3">Discover easy, medium, and hard recipes from our admin chefs. Cook, taste, and enjoy!</p>
        </div>
    </div>

    <!-- FILTER SECTION -->
    <div class="container mt-4 ">
        <div class="card p-3 shadow-sm bg-primary-subtle opacity-75">

            <form method="GET" action="filter.php">
                <div class="row g-2">

                    <!-- Category -->
                    <div class="col-md-4">
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            <?php while ($cat = mysqli_fetch_assoc($category_result)) { ?>
                                <option value="<?php echo $cat['id']; ?>"
                                    <?php if ($category_filter == $cat['id']) echo "selected"; ?>>
                                    <?php echo $cat['category_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Difficulty -->
                    <div class="col-md-4">
                        <select name="difficulty" class="form-select">
                            <option value="">All Difficulty</option>
                            <option value="Easy" <?php if ($difficulty_filter == "Easy") echo "selected"; ?>>Easy</option>
                            <option value="Medium" <?php if ($difficulty_filter == "Medium") echo "selected"; ?>>Medium</option>
                            <option value="Hard" <?php if ($difficulty_filter == "Hard") echo "selected"; ?>>Hard</option>
                        </select>
                    </div>

                    <!-- Cooking Time -->
                    <div class="col-md-3">
                        <select name="time" class="form-select">
                            <option value="">All Cooking Time</option>
                            <option value="15 mins" <?php if ($time_filter == "15 mins") echo "selected"; ?>>15 mins</option>
                            <option value="30 mins" <?php if ($time_filter == "30 mins") echo "selected"; ?>>30 mins</option>
                            <option value="45 mins" <?php if ($time_filter == "45 mins") echo "selected"; ?>>45 mins</option>
                            <option value="1 hour" <?php if ($time_filter == "1 hour") echo "selected"; ?>>1 hour</option>
                        </select>
                    </div>

                    <!-- Button -->
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-success w-100">Go</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- Recipes Grid -->
    <div class="container mt-4">
        <h2 class="mb-4 text-center">Latest Recipes</h2>
        <div class="row g-4">

            <?php if (mysqli_num_rows($posts_query) > 0) { ?>
                <?php while ($post = mysqli_fetch_assoc($posts_query)) { ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="card shadow-sm h-100">
                            <img src="uploads/<?php echo $post['image']; ?>"
                                class="card-img-top"
                                style="height:200px; object-fit:cover;"
                                alt="Recipe Image">
                            <div class="card-body d-flex flex-column bg-info-subtle">
                                <h5 class="card-title"><?php echo $post['title']; ?></h5>
                                <p class="card-text">
                                    <small class="text-muted">
                                        <?php echo $post['category_name']; ?> |
                                        <?php echo $post['difficulty']; ?> |
                                        <?php echo $post['cooking_time']; ?>
                                    </small>
                                </p>
                                <p class="card-text">
                                    <?php echo substr($post['description'], 0, 100); ?>...
                                </p>
                                <a href="single_post.php?id=<?php echo $post['id']; ?>"
                                    class="btn btn-warning mt-auto">
                                    View Recipe
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="col-12 text-center">
                    <p class="text-muted">No recipes found for selected filter.</p>
                </div>
            <?php } ?>

        </div>
    </div>

    <!-- Footer -->

    <?php include("includes/footer.php"); ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>