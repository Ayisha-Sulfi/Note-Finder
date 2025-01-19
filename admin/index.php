<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/admin_login.php");
    exit();
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

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

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .dashboard-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: all var(--transition-speed);
            border: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--color-primary);
        }

        .dashboard-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            width: 100%;
            margin-top: auto;
        }

        .btn-dashboard {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem;
            border-radius: 8px;
            transition: all var(--transition-speed);
        }


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
                <a href="#" class="active">
                    <i class="ph-bold ph-house"></i>
                    Dashboard
                </a>
                <a href="add_admin.php">
                    <i class="ph-bold ph-user-plus"></i>
                    Admin Management
                </a>
                <a href="add_student.php">
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
                    <h1 class="fw-bold">Dashboard</h1>
                    <p class="text-muted">Welcome back, Admin</p>
                </div>
                <div>
                    <button class="btn btn-primary">
                        <i class="ph-bold ph-plus"></i> New Action
                    </button>
                </div>
            </div>

            <div class="dashboard-grid">
             
                <div class="dashboard-card">
                    <i class="ph-bold ph-user-gear"></i>
                    <h4 class="mt-3 mb-4">Admin Management</h4>
                    <div class="dashboard-actions">
                        <a href="add_admin.php" class="btn btn-primary btn-dashboard">
                            <i class="ph-bold ph-plus"></i> Add Admin
                        </a>
                        <a href="view_admins.php" class="btn btn-outline-primary btn-dashboard">
                            <i class="ph-bold ph-list"></i> View Admins
                        </a>
                    </div>
                </div>

           
                <div class="dashboard-card">
                    <i class="ph-bold ph-graduation-cap"></i>
                    <h4 class="mt-3 mb-4">Student Management</h4>
                    <div class="dashboard-actions">
                        <a href="add_student.php" class="btn btn-success btn-dashboard">
                            <i class="ph-bold ph-plus"></i> Add Student
                        </a>
                        <a href="view_students.php" class="btn btn-outline-success btn-dashboard">
                            <i class="ph-bold ph-list"></i> View Students
                        </a>
                    </div>
                </div>

         
                <div class="dashboard-card">
                    <i class="ph-bold ph-chalkboard-teacher"></i>
                    <h4 class="mt-3 mb-4">Faculty Management</h4>
                    <div class="dashboard-actions">
                        <a href="add_faculty.php" class="btn btn-info btn-dashboard">
                            <i class="ph-bold ph-plus"></i> Add Faculty
                        </a>
                        <a href="view_faculties.php" class="btn btn-outline-info btn-dashboard">
                            <i class="ph-bold ph-list"></i> View Faculty
                        </a>
                    </div>
                </div>

            
                <div class="dashboard-card">
                    <i class="ph-bold ph-file-text"></i>
                    <h4 class="mt-3 mb-4">Document Management</h4>
                    <div class="dashboard-actions">
                        <a href="upload_document.php" class="btn btn-warning btn-dashboard">
                            <i class="ph-bold ph-upload"></i> Upload Document
                        </a>
                        <a href="view_documents.php" class="btn btn-outline-warning btn-dashboard">
                            <i class="ph-bold ph-eye"></i> View Documents
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>