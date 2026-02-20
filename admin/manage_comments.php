<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Approve comment
if(isset($_GET['approve'])){
    $id = $_GET['approve'];
    mysqli_query($conn, "UPDATE comments SET status='approved' WHERE id='$id'");
    header("Location: manage_comments.php");
    exit();
}

// Delete comment
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM comments WHERE id='$id'");
    header("Location: manage_comments.php");
    exit();
}

// Fetch all comments
$comments_query = mysqli_query($conn, "
    SELECT comments.*, posts.title AS post_title 
    FROM comments 
    JOIN posts ON comments.post_id = posts.id 
    ORDER BY comments.created_at DESC
");
?>

<?php include("../includes/admin_header.php"); ?>
<div class="container-fluid">
<div class="row">
<?php include("../includes/admin_sidebar.php"); ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
<h2>Manage Comments</h2>
<hr>

<table class="table table-bordered">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Post</th>
<th>Name</th>
<th>Email</th>
<th>Message</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php while($comment = mysqli_fetch_assoc($comments_query)){ ?>
<tr>
<td><?php echo $comment['id']; ?></td>
<td><?php echo $comment['post_title']; ?></td>
<td><?php echo $comment['name']; ?></td>
<td><?php echo $comment['email']; ?></td>
<td><?php echo $comment['message']; ?></td>
<td><?php echo $comment['status']; ?></td>
<td>
<?php if($comment['status']=='pending'){ ?>
<a href="manage_comments.php?approve=<?php echo $comment['id']; ?>" class="btn btn-success btn-sm">Approve</a>
<?php } ?>
<a href="manage_comments.php?delete=<?php echo $comment['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this comment?')">Delete</a>
</td>
</tr>
<?php } ?>
</tbody>
</table>
</main>
</div>
</div>
<?php include("../includes/admin_footer.php"); ?>