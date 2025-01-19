<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
}

require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $admission_number = $_POST['admission_number'];
    $department = $_POST['department'];
    $password = $_POST['password'];


    $check_query = "SELECT * FROM students WHERE admission_number = '$admission_number'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $error = "Admission number already exists";
    } else {
        $insert_query = "INSERT INTO students (name, admission_number, department, password) VALUES ('$name', '$admission_number', '$department', '$password')";
        
        if (mysqli_query($conn, $insert_query)) {
            $success = "Student added successfully";
        } else {
            $error = "Error adding student: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student - Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="admin-styles.css" rel="stylesheet">

    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
    <div class="admin-wrapper">

        <div class="sidebar">
            <div class="sidebar-brand">
                <i class="ph-bold ph-gear"></i>
                <h2>Admin Hub</h2>
            </div>

            <nav class="sidebar-nav">
                <a href="index.php">
                    <i class="ph-bold ph-house"></i>
                    Dashboard
                </a>
                <a href="add_admin.php">
                    <i class="ph-bold ph-user-plus"></i>
                    Admin Management
                </a>
                <a href="add_student.php" class="active">
                    <i class="ph-bold ph-student"></i>
                    Student Management
                </a>
                <a href="add_faculty.php">
                    <i class="ph-bold ph-chalkboard-teacher"></i>
                    Faculty Management
                </a>
                <a href="upload_document.php">
                    <i class="ph-bold ph-file-arrow-up"></i>
                    Document Management
                </a>
            </nav>

            <div class="logout-btn">
                <a href="../config/logout.php">
                    <i class="ph-bold ph-sign-out"></i>
                    Logout
                </a>
            </div>
        </div>


        <div class="main-content">
            <div class="dashboard-header">
                <div>
                    <h1 class="fw-bold">Add Student</h1>
                    <p class="text-muted">Create a new student account</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form-container">
                        <?php if(isset($error)) { ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php } ?>
                        <?php if(isset($success)) { ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php } ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Admission Number</label>
                                <input type="text" name="admission_number" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Department</label>
                                <select name="department" class="form-control" required>
                                    <option value="Computer Science">Computer Science</option>
                                    <option value="Engineering">Engineering</option>
                                    <option value="Mathematics">Mathematics</option>
                                    <option value="Physics">Physics</option>
                                    <option value="Chemistry">Chemistry</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ph-bold ph-plus me-2"></i>Add Student
                                </button><a href="index.php" class="btn btn-secondary">
                                    <i class="ph-bold ph-arrow-left me-2"></i>Back to Dashboard
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>