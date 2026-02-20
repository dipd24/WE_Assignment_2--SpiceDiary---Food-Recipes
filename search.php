<?php
include("includes/db.php");

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

if($keyword == ''){
    header("Location: index.php");
    exit();
}

$safe_keyword = mysqli_real_escape_string($conn, $keyword);

$query = "
    SELECT posts.*, categories.category_name
    FROM posts
    JOIN categories ON posts.category_id = categories.id
    WHERE posts.status='published'
    AND posts.title LIKE '%$safe_keyword%'
    ORDER BY posts.created_at DESC
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Search Results</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include("includes/navbar.php"); ?>

<div class="container mt-5">
    <h3 class="mb-4 text-center">
        Search Results for: "<?php echo htmlspecialchars($keyword); ?>"
    </h3>

    <div class="row g-4">

    <?php if(mysqli_num_rows($result) > 0) { ?>
        <?php while($post = mysqli_fetch_assoc($result)) { ?>
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
                No recipes found with this title.
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