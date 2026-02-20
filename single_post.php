<?php
include("includes/db.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$post_id = $_GET['id'];

// Fetch post details
$post_query = mysqli_query($conn, "
    SELECT posts.*, categories.category_name 
    FROM posts 
    JOIN categories ON posts.category_id = categories.id
    WHERE posts.id='$post_id' AND posts.status='published'
");
$post = mysqli_fetch_assoc($post_query);

if (!$post) {
    echo "<h3 class='text-center mt-5'>Recipe not found!</h3>";
    exit();
}

// Handle comment submission
if(isset($_POST['submit_comment'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    mysqli_query($conn, "INSERT INTO comments (post_id,name,email,message,status) 
        VALUES ('$post_id','$name','$email','$message','pending')");

    $comment_success = "Comment submitted! It will appear after approval.";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $post['title']; ?> - SpiceDiary</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    padding-top: 00px; /* Adjust for sticky navbar */
}
.card-img-top {
    height: 400px;
    object-fit: cover;
}
.navbar-custom {
    background-color: #03513e;
}
footer {
    background-color: #3d016ef6;
    color: white;
    padding: 15px 0;
}
.comment-box {
    border:1px solid #ccc;
    padding:10px;
    border-radius:5px;
    margin-bottom:15px;
}
.card:hover {
    transform: scale(1.02);
    transition: 0.3s;
}
</style>
</head>
<body>

<!-- Navbar -->
<?php include("includes/navbar.php"); ?>


<!-- Post Content -->
<div class="container mt-4 mb-5 ">
    <div class="card shadow-sm ">
        <img src="uploads/<?php echo $post['image']; ?>" class="card-img-top" alt="Recipe Image">
        <div class="card-body">
            <h2 class="card-title"><?php echo $post['title']; ?></h2>
            <p class="text-muted">
                Category: <?php echo $post['category_name']; ?> | Difficulty: <?php echo $post['difficulty']; ?> | Cooking Time: <?php echo $post['cooking_time']; ?>
            </p>
            <hr>
            <p class="card-text"><?php echo nl2br($post['description']); ?></p>
            <a href="index.php" class="btn btn-info mt-3">Back to Recipes</a>
        </div>
    </div>

    <!-- Comment Form -->
    <div class="mt-5">
        <h4>Leave a Comment</h4>
        <?php if(isset($comment_success)){ ?>
            <div class="alert alert-success"><?php echo $comment_success; ?></div>
        <?php } ?>
        <form method="POST">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Message</label>
                <textarea name="message" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" name="submit_comment" class="btn btn-primary">Submit Comment</button>
        </form>
    </div>

    <!-- Approved Comments -->
    <div class="mt-5">
        <h4>Comments</h4>
        <?php
        $comments_query = mysqli_query($conn, "SELECT * FROM comments WHERE post_id='$post_id' AND status='approved' ORDER BY created_at DESC");
        if(mysqli_num_rows($comments_query) == 0){
            echo "<p>No comments yet.</p>";
        }
        while($comment = mysqli_fetch_assoc($comments_query)){ ?>
            <div class="comment-box">
                <strong><?php echo htmlspecialchars($comment['name']); ?></strong>
                <small class="text-muted"> at <?php echo $comment['created_at']; ?></small>
                <p><?php echo nl2br(htmlspecialchars($comment['message'])); ?></p>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Footer -->
<footer class="text-center">
    &copy; <?php echo date("Y"); ?> SpiceDiary. All Rights Reserved.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>