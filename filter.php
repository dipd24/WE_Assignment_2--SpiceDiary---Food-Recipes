<?php
include("includes/db.php");

// GET values
$category_filter   = isset($_GET['category']) ? $_GET['category'] : '';
$difficulty_filter = isset($_GET['difficulty']) ? $_GET['difficulty'] : '';
$time_filter       = isset($_GET['time']) ? $_GET['time'] : '';

// Base query
$query = "
    SELECT posts.*, categories.category_name 
    FROM posts 
    JOIN categories ON posts.category_id = categories.id
    WHERE posts.status='published'
";

// Apply filters
if($category_filter != ''){
    $safe_category = mysqli_real_escape_string($conn,$category_filter);
    $query .= " AND posts.category_id = '$safe_category'";
}

if($difficulty_filter != ''){
    $safe_difficulty = mysqli_real_escape_string($conn,$difficulty_filter);
    $query .= " AND posts.difficulty = '$safe_difficulty'";
}

if($time_filter != ''){
    $safe_time = mysqli_real_escape_string($conn,$time_filter);
    $query .= " AND posts.cooking_time = '$safe_time'";
}

$query .= " ORDER BY posts.created_at DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Filtered Recipes</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include("includes/navbar.php"); ?>

<div class="container mt-5">

    <h2 class="text-center mb-4">Filtered Recipes</h2>

    <div class="row g-4">

        <?php if(mysqli_num_rows($result) > 0){ ?>
            <?php while($post = mysqli_fetch_assoc($result)){ ?>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <img src="uploads/<?php echo $post['image']; ?>" 
                             class="card-img-top"
                             style="height:200px; object-fit:cover;"
                             alt="Recipe Image">
                        <div class="card-body d-flex flex-column">
                            <h5><?php echo $post['title']; ?></h5>
                            <p>
                                <small class="text-muted">
                                    <?php echo $post['category_name']; ?> | 
                                    <?php echo $post['difficulty']; ?> | 
                                    <?php echo $post['cooking_time']; ?>
                                </small>
                            </p>
                            <a href="single_post.php?id=<?php echo $post['id']; ?>" 
                               class="btn btn-success mt-auto">
                               View Recipe
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="col-12 text-center">
                <div class="alert alert-warning">
                    No recipes found based on selected filters.
                </div>
            </div>
        <?php } ?>

    </div>

    <!-- Back Button -->
    <div class="text-center mt-5 mb-5">
        <a href="index.php" class="btn btn-warning">
            ← Back to Homepage
        </a>
    </div>

</div>

</body>
</html>