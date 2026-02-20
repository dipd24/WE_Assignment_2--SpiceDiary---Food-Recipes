<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$query = "
SELECT posts.*, categories.category_name AS category_name 
FROM posts 
JOIN categories ON posts.category_id = categories.id
ORDER BY posts.id DESC
";

$result = mysqli_query($conn, $query);
?>

<?php include("../includes/admin_header.php"); ?>

<div class="container-fluid">
<div class="row">

<?php include("../includes/admin_sidebar.php"); ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">

<h2>Manage Posts</h2>
<hr>

<table class="table table-bordered">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Title</th>
<th>Category</th>
<th>Status</th>
<th>Date</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['category_name']; ?></td>
<td><?php echo $row['status']; ?></td>
<td><?php echo $row['created_at']; ?></td>

<td>
    <a href="edit_post.php?id=<?php echo $row['id']; ?>" 
       class="btn btn-primary btn-sm">
       Edit
    </a>
    <a href="delete_post.php?id=<?php echo $row['id']; ?>" 
       class="btn btn-danger btn-sm"
       onclick="return confirm('Delete this post?')">
       Delete
    </a>
</td>

</tr>

<?php } ?>

</tbody>
</table>

</main>
</div>
</div>

<?php include("../includes/admin_footer.php"); ?>