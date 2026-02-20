<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

/* -------------------------
   ADD CATEGORY
--------------------------*/
if (isset($_POST['add_category'])) {
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);

    if (!empty($category_name)) {
        mysqli_query($conn, "INSERT INTO categories (category_name) VALUES ('$category_name')");
    }
}

/* -------------------------
   DELETE CATEGORY
--------------------------*/
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM categories WHERE id=$id");
    header("Location: manage_categories.php");
    exit();
}
?>

<?php include("../includes/admin_header.php"); ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include("../includes/admin_sidebar.php"); ?>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
            <h2>Manage Categories</h2>
            <hr>

            <!-- Add Category Form -->
            <div class="card p-4 shadow-sm mb-4">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-10">
                            <input type="text" name="category_name" class="form-control" placeholder="Enter category name" required>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" name="add_category" class="btn btn-success w-100">
                                Add
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Category Table -->
            <div class="card shadow-sm">
                <div class="card-body">

                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM categories ORDER BY id DESC");

                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['category_name']; ?></td>
                                <td>
                                    <a href="manage_categories.php?delete=<?php echo $row['id']; ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure?');">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>

                </div>
            </div>

        </main>
    </div>
</div>

<?php include("../includes/admin_footer.php"); ?>