<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Category fetch
$cat_query = mysqli_query($conn, "SELECT * FROM categories");

if (isset($_POST['submit'])) {

    $user_id = $_SESSION['admin_id'];
    $category_id = $_POST['category'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $cooking_time = $_POST['cooking_time'];
    $difficulty = $_POST['difficulty'];
    $status = $_POST['status'];

    $image_name = $_FILES['image']['name'];
    $temp_name = $_FILES['image']['tmp_name'];

    move_uploaded_file($temp_name, "../uploads/".$image_name);

    $query = "INSERT INTO posts 
    (user_id, category_id, title, description, image, cooking_time, difficulty, status)
    VALUES 
    ('$user_id','$category_id','$title','$description',
     '$image_name','$cooking_time','$difficulty','$status')";

    mysqli_query($conn, $query);

    header("Location: manage_posts.php");
}
?>

<?php include("../includes/admin_header.php"); ?>

<div class="container-fluid">
<div class="row">

<?php include("../includes/admin_sidebar.php"); ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">

<h2>Add Recipe</h2>
<hr>

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">
<label>Category</label>
<select name="category" class="form-control" required>
<?php while($cat = mysqli_fetch_assoc($cat_query)) { ?>
<option value="<?php echo $cat['id']; ?>">
<?php echo $cat['category_name']; // <-- corrected ?>
</option>
<?php } ?>
</select>
</div>

<div class="mb-3">
<label>Title</label>
<input type="text" name="title" class="form-control" required>
</div>

<div class="mb-3">
<label>Description</label>
<textarea name="description" class="form-control" rows="4" required></textarea>
</div>

<div class="mb-3">
<label>Cooking Time</label>
<input type="text" name="cooking_time" class="form-control">
</div>

<div class="mb-3">
<label>Difficulty</label>
<select name="difficulty" class="form-control">
<option>Easy</option>
<option>Medium</option>
<option>Hard</option>
</select>
</div>

<div class="mb-3">
<label>Status</label>
<select name="status" class="form-control">
<option value="published">Published</option>
<option value="draft">Draft</option>
</select>
</div>

<div class="mb-3">
<label>Image</label>
<input type="file" name="image" class="form-control" required>
</div>

<button type="submit" name="submit" class="btn btn-success mt-5 mb-5">
Publish
</button>

</form>

</main>
</div>
</div>

<?php include("../includes/admin_footer.php"); ?>
