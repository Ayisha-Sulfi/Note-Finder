<?php

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
}

require_once '../config/database.php';


if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: view_students.php");
    exit();
}

$student_id = $_GET['id'];

$query = "SELECT * FROM students WHERE id = '$student_id'";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $admission_number = $_POST['admission_number'];
    $department = $_POST['department'];
    $password = $_POST['password'];

   
    $check_query = "SELECT * FROM students WHERE admission_number = '$admission_number' AND id != '$student_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $error = "Admission number already exists";
    } else {
     
        $update_query = "UPDATE students SET name = '$name', admission_number = '$admission_number', department = '$department', password = '$password' WHERE id = '$student_id'";
        
        if (mysqli_query($conn, $update_query)) {
            $success = "Student updated successfully";
    
            $result = mysqli_query($conn, $query);
            $student = mysqli_fetch_assoc($result);
        } else {
            $error = "Error updating student: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Student</h2>
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
                       value="<?php echo htmlspecialchars($student['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Admission Number</label>
                <input type="text" name="admission_number" class="form-control" 
                       value="<?php echo htmlspecialchars($student['admission_number']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Department</label>
                <select name="department" class="form-control" required>
                    <option value="Computer Science" <?php echo ($student['department'] == 'Computer Science') ? 'selected' : ''; ?>>Computer Science</option>
                    <option value="Engineering" <?php echo ($student['department'] == 'Engineering') ? 'selected' : ''; ?>>Engineering</option>
                    <option value="Mathematics" <?php echo ($student['department'] == 'Mathematics') ? 'selected' : ''; ?>>Mathematics</option>
                    <option value="Physics" <?php echo ($student['department'] == 'Physics') ? 'selected' : ''; ?>>Physics</option>
                    <option value="Chemistry" <?php echo ($student['department'] == 'Chemistry') ? 'selected' : ''; ?>>Chemistry</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" 
                       value="<?php echo htmlspecialchars($student['password']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Student</button>
        </form>
        <div class="mt-3">
            <a href="view_students.php" class="btn btn-secondary">Back to Student List</a>
        </div>
    </div>
</body>
</html>