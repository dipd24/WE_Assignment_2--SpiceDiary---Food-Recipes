<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$post_id = $_GET['id'];

// Fetch post
$post_query = mysqli_query($conn, "SELECT * FROM posts WHERE id='$post_id'");
$post = mysqli_fetch_assoc($post_query);

// Fetch categories
$cat_query = mysqli_query($conn, "SELECT * FROM categories");

if (isset($_POST['submit'])) {

    $category_id = $_POST['category'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $cooking_time = $_POST['cooking_time'];
    $difficulty = $_POST['difficulty'];
    $status = $_POST['status'];

    $image_name = $_FILES['image']['name'];
    $temp_name = $_FILES['image']['tmp_name'];

    if(!empty($image_name)){
        move_uploaded_file($temp_name, "../uploads/".$image_name);
    } else {
        $image_name = $post['image']; // keep old image
    }

    $query = "UPDATE posts SET
              category_id='$category_id',
              title='$title',
              description='$description',
              image='$image_name',
              cooking_time='$cooking_time',
              difficulty='$difficulty',
              status='$status'
              WHERE id='$post_id'";

    mysqli_query($conn, $query);

    header("Location: manage_posts.php");
    exit();
}
?>

<?php include("../includes/admin_header.php"); ?>

<div class="container-fluid">
<div class="row">

<?php include("../includes/admin_sidebar.php"); ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">

<h2>Edit Recipe</h2>
<hr>

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">
<label>Category</label>
<select name="category" class="form-control" required>
<?php while($cat = mysqli_fetch_assoc($cat_query)) { ?>
<option value="<?php echo $cat['id']; ?>" 
<?php if($cat['id']==$post['category_id']) echo 'selected'; ?>>
<?php echo $cat['category_name']; ?>
</option>
<?php } ?>
</select>
</div>

<div class="mb-3">
<label>Title</label>
<input type="text" name="title" class="form-control" value="<?php echo $post['title']; ?>" required>
</div>

<div class="mb-3">
<label>Description</label>
<textarea name="description" class="form-control" rows="4" required><?php echo $post['description']; ?></textarea>
</div>

<div class="mb-3">
<label>Cooking Time</label>
<input type="text" name="cooking_time" class="form-control" value="<?php echo $post['cooking_time']; ?>">
</div>

<div class="mb-3">
<label>Difficulty</label>
<select name="difficulty" class="form-control">
<option <?php if($post['difficulty']=='Easy') echo 'selected'; ?>>Easy</option>
<option <?php if($post['difficulty']=='Medium') echo 'selected'; ?>>Medium</option>
<option <?php if($post['difficulty']=='Hard') echo 'selected'; ?>>Hard</option>
</select>
</div>

<div class="mb-3">
<label>Status</label>
<select name="status" class="form-control">
<option value="published" <?php if($post['status']=='published') echo 'selected'; ?>>Published</option>
<option value="draft" <?php if($post['status']=='draft') echo 'selected'; ?>>Draft</option>
</select>
</div>

<div class="mb-3">
<label>Current Image</label><br>
<img src="../uploads/<?php echo $post['image']; ?>" width="120">
</div>

<div class="mb-3">
<label>Change Image</label>
<input type="file" name="image" class="form-control">
</div>

<button type="submit" name="submit" class="btn btn-success">Update Post</button>

</form>

</main>
</div>
</div>

<?php include("../includes/admin_footer.php"); ?>