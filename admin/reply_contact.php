<?php
include("../includes/db.php");

if(!isset($_GET['id'])){
    header("Location: manage_contacts.php");
    exit();
}

$id = intval($_GET['id']);

// Fetch message
$result = mysqli_query($conn, "SELECT * FROM contact_messages WHERE id=$id");
$message = mysqli_fetch_assoc($result);

if(!$message){
    header("Location: manage_contacts.php");
    exit();
}

// Reply submit
if(isset($_POST['submit'])){
    $reply = mysqli_real_escape_string($conn, $_POST['reply']);

    mysqli_query($conn, "
        UPDATE contact_messages 
        SET reply='$reply', replied_at=NOW()
        WHERE id=$id
    ");

    header("Location: manage_contacts.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Reply Message</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3 class="mb-4">Reply to Message</h3>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($message['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($message['email']); ?></p>
            <p><strong>Message:</strong><br>
               <?php echo nl2br(htmlspecialchars($message['message'])); ?>
            </p>
        </div>
    </div>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Your Reply</label>
            <textarea name="reply" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" name="submit" class="btn btn-success">
            Send Reply
        </button>

        <a href="manage_contacts.php" class="btn btn-secondary">
            Back
        </a>
    </form>

</div>

</body>
</html>