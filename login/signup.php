<?php
session_start();
require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $admission_number = $_POST['admission_number'];
    $department = $_POST['department'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {

        $check_query = "SELECT * FROM students WHERE admission_number = '$admission_number'";
        $check_result = mysqli_query($conn, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            $error = "Admission number already exists";
        } else {

            $insert_query = "INSERT INTO students (name, admission_number, department, password) 
                             VALUES ('$name', '$admission_number', '$department', '$password')";
            
            if (mysqli_query($conn, $insert_query)) {
                header("Location: student_login.php");
                exit();
            } else {
                $error = "Error creating account: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Signup</title>
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
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .signup-container {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            padding: 2.5rem;
            width: 100%;
            max-width: 500px;
        }

        .signup-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .signup-header i {
            color: var(--color-primary);
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .signup-header h2 {
            font-weight: 700;
            color: var(--color-text);
        }

        .form-control {
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            transition: all var(--transition-speed);
        }

        .form-control:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
        }

        .btn-signup {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            border: none;
            padding: 0.75rem;
            transition: all var(--transition-speed);
        }

        .btn-signup:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 14px rgba(59, 130, 246, 0.3);
        }

        .login-link {
            text-align: center;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="signup-header">
            <i class="ph-bold ph-graduation-cap"></i>
            <h2>Student Signup</h2>
            <p class="text-muted">Create your student account</p>
        </div>

        <?php if(isset($error)) { ?>
            <div class="alert alert-danger mb-4">
                <i class="ph-bold ph-warning me-2"></i><?php echo $error; ?>
            </div>
        <?php } ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="ph-bold ph-user"></i></span>
                    <input type="text" name="name" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Admission Number</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="ph-bold ph-identification-card"></i></span>
                    <input type="text" name="admission_number" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Department</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="ph-bold ph-buildings"></i></span>
                    <select name="department" class="form-control" required>
                        <option value="">Select Department</option>
                        <option value="Computer Science">Computer Science</option>
                        <option value="Information Technology">Information Technology</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Mechanical Engineering">Mechanical Engineering</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="ph-bold ph-lock"></i></span>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label">Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="ph-bold ph-lock"></i></span>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
            </div>
            <button type="submit" class="btn btn-signup w-100 text-white">
                <i class="ph-bold ph-sign-in me-2"></i>Create Account
            </button>
        </form>
        <div class="login-link mt-3 text-center">
            Already have an account? <a href="student_login.php" class="text-primary">Login</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>