<?php
include("includes/db.php");

$success = "";
$error = "";

// Form submit check
if(isset($_POST['submit'])){

    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if(!empty($name) && !empty($email) && !empty($message)){

        $insert_query = "INSERT INTO contact_messages (name,email,message) 
                         VALUES ('$name','$email','$message')";

        if(mysqli_query($conn,$insert_query)){
            $success = "Your message has been sent successfully!";
        } else {
            $error = "Something went wrong. Try again.";
        }

    } else {
        $error = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us - SpiceDiary</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include("includes/navbar.php"); ?>

<div class="container mt-5">
    <h2 class="mb-4">Contact Us</h2>

    <?php if($success != "") { ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php } ?>

    <?php if($error != "") { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Your Name</label>
            <input type="text" name="name" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Your Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea name="message" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit" name="submit" class="btn btn-warning">
            Send Message
        </button>

    </form>
</div>

</body>
</html>