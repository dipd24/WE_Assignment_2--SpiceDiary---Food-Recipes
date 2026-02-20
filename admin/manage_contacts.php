<?php
include("../includes/db.php");

// Delete message
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM contact_messages WHERE id = $id");
    header("Location: manage_contacts.php");
    exit();
}

// Fetch messages
$messages = mysqli_query($conn, "
    SELECT * FROM contact_messages 
    ORDER BY created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Contact Messages</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
/* Optional: make table scrollable on small screens */
.table-responsive {
    max-height: 600px;
    overflow-y: auto;
}
</style>
</head>
<body>
<?php include("../includes/admin_header.php"); ?>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <?php include("../includes/admin_sidebar.php"); ?>

        <!-- Main Content -->
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">

            <h2 class="mb-4">Manage Contact Messages</h2>

            <div class="card shadow-sm">
                <div class="card-body table-responsive">

                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th style="width:35%;">Message</th>
                                <th>Reply</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php if(mysqli_num_rows($messages) > 0){ ?>
                            <?php while($row = mysqli_fetch_assoc($messages)){ ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td>
                                        <?php echo nl2br(htmlspecialchars(substr($row['message'], 0, 150))); ?>...
                                    </td>
                                    <td>
                                        <?php if(isset($row['reply']) && $row['reply'] != '') { ?>
                                            <small class="text-success">
                                                <?php echo nl2br(htmlspecialchars(substr($row['reply'],0,100))); ?>...
                                                <br><em><?php echo $row['replied_at']; ?></em>
                                            </small>
                                        <?php } else { ?>
                                            <span class="text-muted">Not replied</span>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td>
                                        <a href="reply_contact.php?id=<?php echo $row['id']; ?>" 
                                           class="btn btn-sm btn-primary mb-1">
                                           Reply
                                        </a>
                                        <a href="manage_contacts.php?delete=<?php echo $row['id']; ?>" 
                                           class="btn btn-sm btn-danger mb-1"
                                           onclick="return confirm('Are you sure you want to delete this message?');">
                                           Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="7" class="text-center">No messages found.</td>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>

                </div>
            </div>

        </div>

    </div>
</div>

</body>
</html>
<?php include("../includes/admin_footer.php"); ?>