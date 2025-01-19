<?php
session_start();

if (!isset($_SESSION['faculty_logged_in']) || $_SESSION['faculty_logged_in'] !== true) {
    header("Location: ../login/faculty_login.php");
    exit();
}

require_once '../config/database.php';

$programs = [
    'Undergraduate' => [
        'BCA' => [
            'Semester 1' => ['Introduction to Computers', 'Mathematics', 'Communication Skills', 'Programming Fundamentals', 'Basic Electronics'],
            'Semester 2' => ['Data Structures', 'Computer Networks', 'Operating Systems', 'Database Management Systems', 'Object-Oriented Programming'],
            'Semester 3' => ['Web Development', 'Java Programming', 'Software Engineering', 'Computer Graphics', 'Numerical Methods']
        ],
        'BCOM' => [
            'Semester 1' => ['Business Communication', 'Financial Accounting', 'Economics', 'Business Mathematics', 'Computer Applications'],
            'Semester 2' => ['Corporate Accounting', 'Business Law', 'Marketing Management', 'Microeconomics', 'Business Statistics'],
            'Semester 3' => ['Cost Accounting', 'Financial Management', 'Business Research Methods', 'Taxation', 'International Business']
        ],
        'BSW' => [
            'Semester 1' => ['Introduction to Social Work', 'Sociology', 'Psychology', 'Human Rights', 'Social Welfare Administration'],
            'Semester 2' => ['Social Research Methods', 'Community Development', 'Child and Family Welfare', 'Social Policy', 'Counseling Techniques'],
            'Semester 3' => ['Rural and Urban Community Development', 'Disability Studies', 'Gender Studies', 'Social Justice', 'Field Work Practice']
        ],
        'BBA' => [
            'Semester 1' => ['Principles of Management', 'Business Economics', 'Organizational Behavior', 'Business Communication', 'Accounting for Managers'],
            'Semester 2' => ['Marketing Management', 'Financial Management', 'Human Resource Management', 'Business Law', 'Entrepreneurship'],
            'Semester 3' => ['Strategic Management', 'International Business', 'Business Analytics', 'Operations Management', 'Corporate Finance']
        ]
    ],
    'Postgraduate' => [
        'MCA' => [
            'Semester 1' => ['Advanced Computer Architecture', 'Advanced Programming Techniques', 'Machine Learning Fundamentals', 'Advanced Database Systems', 'Research Methodology'],
            'Semester 2' => ['Cloud Computing', 'Artificial Intelligence', 'Software Project Management', 'Network Security', 'Advanced Web Technologies'],
            'Semester 3' => ['Data Science', 'Advanced Algorithms', 'Enterprise Architecture', 'Big Data Analytics', 'Research Project']
        ],
        'MBA' => [
            'Semester 1' => ['Advanced Strategic Management', 'Managerial Economics', 'Organizational Behavior and Leadership', 'Business Research Methods', 'Financial Management'],
            'Semester 2' => ['Marketing Strategy', 'Global Business Environment', 'Advanced Human Resource Management', 'Business Analytics', 'Corporate Finance'],
            'Semester 3' => ['Entrepreneurship and Innovation', 'Supply Chain Management', 'International Business Strategy', 'Digital Business Transformation', 'Capstone Project']
        ],
        'M.COM' => [
            'Semester 1' => ['Advanced Accounting', 'Managerial Economics', 'Research Methodology', 'Financial Markets and Institutions', 'Business Statistics'],
            'Semester 2' => ['Advanced Corporate Accounting', 'Taxation and Tax Planning', 'Investment Management', 'Financial Analysis', 'International Business Finance'],
            'Semester 3' => ['Strategic Management', 'Business Ethics and Corporate Governance', 'Advanced Financial Management', 'Dissertation/Project', 'Emerging Trends in Commerce']
        ]
    ]
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $degree_level = $_POST['degree_level'];
    $program = $_POST['program'];
    $semester = $_POST['semester'];
    $course = $_POST['course'];
    $document_type = $_POST['document_type'];

    $target_dir = "../uploads/";
    $file_name = basename($_FILES["document"]["name"]);
    $target_file = $target_dir . $file_name;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $allowed_types = ['pdf', 'doc', 'docx', 'txt'];
    if (in_array($file_type, $allowed_types)) {
        if (move_uploaded_file($_FILES["document"]["tmp_name"], $target_file)) {
            $faculty_id = $_SESSION['faculty_id'];
            $insert_query = "INSERT INTO documents 
                             (uploader_id, uploader_type, degree_level, program, semester, course, document_type, file_name, file_path) 
                             VALUES 
                             ('$faculty_id', 'faculty', '$degree_level', '$program', '$semester', '$course', '$document_type', '$file_name', '$target_file')";
            
            if (mysqli_query($conn, $insert_query)) {
                $success = "Document uploaded successfully";
            } else {
                $error = "Error uploading document to database: " . mysqli_error($conn);
            }
        } else {
            $error = "Sorry, there was an error uploading your file.";
        }
    } else {
        $error = "Sorry, only PDF, DOC, DOCX, and TXT files are allowed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Document - Faculty Dashboard</title>

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

        .form-container {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
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
                <a href="upload_document.php" class="active">
                    <i class="ph-bold ph-file-arrow-up"></i>
                    Document Management
                </a>
                <a href="view_documents.php">
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
            <div class="dashboard-header">
                <div>
                    <h1 class="fw-bold">Upload Document</h1>
                    <p class="text-muted">Manage and upload course documents</p>
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
                        <form method="POST" enctype="multipart/form-data" id="uploadForm">
                            <div class="mb-3">
                                <label class="form-label">Degree Level</label>
                                <select name="degree_level" class="form-control" id="degreeLevelSelect" required>
                                    <option value="">Select Degree Level</option>
                                    <option value="Undergraduate">Undergraduate</option>
                                    <option value="Postgraduate">Postgraduate</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Program</label>
                                <select name="program" class="form-control" id="programSelect" required>
                                    <option value="">Select Program</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Semester</label>
                                <select name="semester" class="form-control" id="semesterSelect" required>
                                    <option value="">Select Semester</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Course</label>
                                <select name="course" class="form-control" id="courseSelect" required>
                                    <option value="">Select Course</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Document Type</label>
                                <select name="document_type" class="form-control" required>
                                    <option value="Notes">Notes</option>
                                    <option value="Question Paper">Question Paper</option>
                                    <option value="Syllabus">Syllabus</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Upload Document</label>
                                <input type="file" name="document" class="form-control" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ph-bold ph-upload me-2"></i>Upload Document
                                </button>
                                <a href="index.php" class="btn btn-secondary">
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
    <script>
        const programs = <?php echo json_encode($programs); ?>;
        const degreeLevelSelect = document.getElementById('degreeLevelSelect');
        const programSelect = document.getElementById('programSelect');
        const semesterSelect = document.getElementById('semesterSelect');
        const courseSelect = document.getElementById('courseSelect');

        function updatePrograms() {
            const selectedDegreeLevel = degreeLevelSelect.value;
            programSelect.innerHTML = '<option value="">Select Program</option>';
            semesterSelect.innerHTML = '<option value="">Select Semester</option>';
            courseSelect.innerHTML = '<option value="">Select Course</option>';
            
            if (selectedDegreeLevel && programs[selectedDegreeLevel]) {
                const programsForDegreeLevel = Object.keys(programs[selectedDegreeLevel]);
                programsForDegreeLevel.forEach(program => {
                    const option = document.createElement('option');
                    option.value = program;
                    option.textContent = program;
                    programSelect.appendChild(option);
                });
            }
        }

        function updateSemesters() {
            const selectedDegreeLevel = degreeLevelSelect.value;
            const selectedProgram = programSelect.value;
            semesterSelect.innerHTML = '<option value="">Select Semester</option>';
            courseSelect.innerHTML = '<option value="">Select Course</option>';
            
            if (selectedDegreeLevel && selectedProgram && programs[selectedDegreeLevel][selectedProgram]) {
                const semestersForProgram = Object.keys(programs[selectedDegreeLevel][selectedProgram]);
                semestersForProgram.forEach(semester => {
                    const option = document.createElement('option');
                    option.value = semester;
                    option.textContent = semester;
                    semesterSelect.appendChild(option);
                });
            }
        }

        function updateCourses() {
            const selectedDegreeLevel = degreeLevelSelect.value;
            const selectedProgram = programSelect.value;
            const selectedSemester = semesterSelect.value;
            courseSelect.innerHTML = '<option value="">Select Course</option>';
            
            if (selectedDegreeLevel && selectedProgram && selectedSemester && 
                programs[selectedDegreeLevel][selectedProgram][selectedSemester]) {
                const coursesForSemester = programs[selectedDegreeLevel][selectedProgram][selectedSemester];
                coursesForSemester.forEach(course => {
                    const option = document.createElement('option');
                    option.value = course;
                    option.textContent = course;
                    courseSelect.appendChild(option);
                });
            }
        }

        degreeLevelSelect.addEventListener('change', updatePrograms);
        programSelect.addEventListener('change', updateSemesters);
        semesterSelect.addEventListener('change', updateCourses);
    </script>
</body>
</html>