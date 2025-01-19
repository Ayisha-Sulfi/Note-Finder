<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
}

require_once '../config/database.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: view_admins.php");
    exit();
}

$admin_id = $_GET['id'];


$query = "SELECT * FROM admins WHERE id = '$admin_id'";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check_query = "SELECT * FROM admins WHERE username = '$username' AND id != '$admin_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $error = "Username already exists";
    } else {
    
        $update_query = "UPDATE admins SET name = '$name', username = '$username', password = '$password' WHERE id = '$admin_id'";
        
        if (mysqli_query($conn, $update_query)) {
            $success = "Admin updated successfully";
        
            $result = mysqli_query($conn, $query);
            $admin = mysqli_fetch_assoc($result);
        } else {
            $error = "Error updating admin: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Admin</h2>
        <?php if(isset($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>
        <?php if(isset($success)) { ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php } ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" 
                       value="<?php echo htmlspecialchars($admin['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" 
                       value="<?php echo htmlspecialchars($admin['username']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" 
                       value="<?php echo htmlspecialchars($admin['password']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Admin</button>
        </form>
        <div class="mt-3">
            <a href="view_admins.php" class="btn btn-secondary">Back to Admin List</a>
        </div>
    </div>
</body>
</html>