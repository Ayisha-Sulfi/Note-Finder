<?php
session_start();

if (!isset($_SESSION['faculty_logged_in']) || $_SESSION['faculty_logged_in'] !== true) {
    header("Location: ../login/faculty_login.php");
    exit();
}

require_once '../config/database.php';

$faculty_id = $_SESSION['faculty_id'];
$query = "SELECT * FROM documents WHERE uploader_id = '$faculty_id' AND uploader_type = 'faculty' ORDER BY upload_date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Documents - Faculty</title>

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

        .faculty-wrapper {
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

        /* Main Content */
        .main-content {
            padding: 2rem;
            background-color: var(--bg-primary);
        }

        .documents-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead {
            background-color: var(--bg-primary);
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,0.03);
        }

        .btn-view {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

   
        @media (max-width: 992px) {
            .faculty-wrapper {
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
    <div class="faculty-wrapper">

        <div class="sidebar">
            <div class="sidebar-brand">
                <i class="ph-bold ph-chalkboard-teacher"></i>
                <h2>Faculty Portal</h2>
            </div>

            <nav class="sidebar-nav">
                <a href="index.php">
                    <i class="ph-bold ph-house"></i>
                    Dashboard
                </a>
                <a href="upload_document.php">
                    <i class="ph-bold ph-upload"></i>
                    Upload Document
                </a>
                <a href="view_documents.php" class="active">
                    <i class="ph-bold ph-file-text"></i>
                    My Documents
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
            <div class="row">
                <div class="col-12">
                    <div class="documents-card">
                        <h2 class="mb-4">
                            <i class="ph-bold ph-file-text text-primary me-2"></i>
                            My Uploaded Documents
                        </h2>

                        <?php if(mysqli_num_rows($result) == 0) { ?>
                            <div class="alert alert-info">
                                <i class="ph-bold ph-info-circle me-2"></i>
                                You haven't uploaded any documents yet.
                            </div>
                        <?php } else { ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Degree Level</th>
                                            <th>Program</th>
                                            <th>Semester</th>
                                            <th>Course</th>
                                            <th>Document Type</th>
                                            <th>File Name</th>
                                            <th>Upload Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['degree_level']); ?></td>
                                            <td><?php echo htmlspecialchars($row['program']); ?></td>
                                            <td><?php echo htmlspecialchars($row['semester']); ?></td>
                                            <td><?php echo htmlspecialchars($row['course']); ?></td>
                                            <td><?php echo htmlspecialchars($row['document_type']); ?></td>
                                            <td><?php echo htmlspecialchars($row['file_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['upload_date']); ?></td>
                                            <td>
                                                <a href="../uploads/<?php echo urlencode($row['file_name']); ?>" 
                                                   target="_blank" class="btn btn-sm btn-primary btn-view">
                                                    <i class="ph-bold ph-eye me-1"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>