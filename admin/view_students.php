<?php

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
}

require_once '../config/database.php';


$query = "SELECT * FROM students";
$result = mysqli_query($conn, $query);


if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM students WHERE id = '$delete_id'";
    
    if (mysqli_query($conn, $delete_query)) {
        $success = "Student deleted successfully";
     
        header("Location: view_students.php");
        exit();
    } else {
        $error = "Error deleting student: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students - Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root {
            --bg-primary: #f4f6f9;
            --color-primary: #3b82f6;
            --color-secondary: #6366f1;
            --color-text: #1f2937;
            --color-text-muted: #6b7280;
            --card-bg: #ffffff;
            --transition-speed: 0.3s;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: var(--bg-primary);
            color: var(--color-text);
            line-height: 1.6;
        }

        .admin-wrapper {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            color: white;
            padding: 2rem 0;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            text-align: center;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .sidebar-brand h2 {
            margin: 0;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .sidebar-nav {
            flex-grow: 1;
        }

        .sidebar-nav a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 24px;
            gap: 12px;
            transition: all var(--transition-speed);
        }

        .sidebar-nav a:hover, .sidebar-nav a.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .sidebar-nav a i {
            font-size: 1.2rem;
        }

        .logout-btn {
            margin-top: auto;
            padding: 1rem;
            text-align: center;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .logout-btn a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        /* Main Content */
        .main-content {
            padding: 2rem;
            background-color: var(--bg-primary);
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .table-container {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        /* Action buttons */
        .btn-action {
            margin-right: 0.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .admin-wrapper {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                position: static;
                height: auto;
            }
        }
    </style>
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
                    <h1 class="fw-bold">Student List</h1>
                    <p class="text-muted">Manage student accounts</p>
                </div>
                <div>
                    <a href="add_student.php" class="btn btn-primary">
                        <i class="ph-bold ph-plus me-2"></i>Add New Student
                    </a>
                </div>
            </div>

            <div class="table-container">
                <?php if(isset($error)) { ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php } ?>
                <?php if(isset($success)) { ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php } ?>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Admission Number</th>
                                <th>Department</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['admission_number']); ?></td>
                                <td><?php echo htmlspecialchars($row['department']); ?></td>
                                <td>
                                    <a href="edit_student.php?id=<?php echo $row['id']; ?>" 
                                       class="btn btn-sm btn-primary btn-action">
                                        <i class="ph-bold ph-pencil me-1"></i>Edit
                                    </a>
                                    <a href="view_students.php?delete_id=<?php echo $row['id']; ?>" 
                                       class="btn btn-sm btn-danger btn-action" 
                                       onclick="return confirm('Are you sure you want to delete this student?');">
                                        <i class="ph-bold ph-trash me-1"></i>Delete
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>