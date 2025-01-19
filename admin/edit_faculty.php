<?php

session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
}

require_once '../config/database.php';


if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: view_faculties.php");
    exit();
}

$faculty_id = $_GET['id'];


$query = "SELECT * FROM faculties WHERE id = '$faculty_id'";
$result = mysqli_query($conn, $query);
$faculty = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $department = $_POST['department'];
    $password = $_POST['password'];

    
    $check_query = "SELECT * FROM faculties WHERE username = '$username' AND id != '$faculty_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $error = "Username already exists";
    } else {
        
        $update_query = "UPDATE faculties SET name = '$name', username = '$username', department = '$department', password = '$password' WHERE id = '$faculty_id'";
        
        if (mysqli_query($conn, $update_query)) {
            $success = "Faculty updated successfully";
          
            $result = mysqli_query($conn, $query);
            $faculty = mysqli_fetch_assoc($result);
        } else {
            $error = "Error updating faculty: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Faculty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Faculty</h2>
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
                       value="<?php echo htmlspecialchars($faculty['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" 
                       value="<?php echo htmlspecialchars($faculty['username']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Department</label>
                <select name="department" class="form-control" required>
                    <option value="Computer Science" <?php echo ($faculty['department'] == 'Computer Science') ? 'selected' : ''; ?>>Computer Science</option>
                    <option value="Engineering" <?php echo ($faculty['department'] == 'Engineering') ? 'selected' : ''; ?>>Engineering</option>
                    <option value="Mathematics" <?php echo ($faculty['department'] == 'Mathematics') ? 'selected' : ''; ?>>Mathematics</option>
                    <option value="Physics" <?php echo ($faculty['department'] == 'Physics') ? 'selected' : ''; ?>>Physics</option>
                    <option value="Chemistry" <?php echo ($faculty['department'] == 'Chemistry') ? 'selected' : ''; ?>>Chemistry</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" 
                       value="<?php echo htmlspecialchars($faculty['password']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Faculty</button>
        </form>
        <div class="mt-3">
            <a href="view_faculties.php" class="btn btn-secondary">Back to Faculty List</a>
        </div>
    </div>
</body>
</html>