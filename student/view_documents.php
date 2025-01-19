<?php
session_start();

if (!isset($_SESSION['student_logged_in']) || $_SESSION['student_logged_in'] !== true) {
    header("Location: ../login/student_login.php");
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
            'Semester 1' => ['Advanced Computer Architecture', 'Advanced Algorithms', 'Software Project Management', 'Machine Learning', 'Advanced Database Systems'],
            'Semester 2' => ['Cloud Computing', 'Artificial Intelligence', 'Network Security', 'Data Mining', 'Advanced Software Engineering'],
            'Semester 3' => ['Big Data Analytics', 'Mobile Application Development', 'Distributed Systems', 'Research Methodology', 'Dissertation']
        ],
        'MBA' => [
            'Semester 1' => ['Advanced Strategic Management', 'Corporate Finance', 'Organizational Behavior', 'Marketing Strategy', 'Business Analytics'],
            'Semester 2' => ['Global Business Environment', 'Leadership and Change Management', 'Financial Management', 'Advanced Marketing', 'Business Research Methods'],
            'Semester 3' => ['Entrepreneurship', 'Strategic Decision Making', 'International Business', 'Project Management', 'Dissertation']
        ],
        'M.COM' => [
            'Semester 1' => ['Advanced Accounting', 'Financial Management', 'Corporate Governance', 'Quantitative Methods', 'Business Research'],
            'Semester 2' => ['Advanced Cost Management', 'Financial Markets and Institutions', 'Taxation', 'Strategic Management', 'International Business'],
            'Semester 3' => ['Corporate Financial Policy', 'Investment Analysis', 'Financial Services', 'Emerging Trends in Commerce', 'Dissertation']
        ]
    ]
];

$degree_level = isset($_GET['degree_level']) ? $_GET['degree_level'] : '';
$program = isset($_GET['program']) ? $_GET['program'] : '';
$semester = isset($_GET['semester']) ? $_GET['semester'] : '';
$course = isset($_GET['course']) ? $_GET['course'] : '';
$document_type = isset($_GET['document_type']) ? $_GET['document_type'] : '';

$query = "SELECT * FROM documents WHERE 1=1";
if (!empty($degree_level)) $query .= " AND degree_level = '$degree_level'";
if (!empty($program)) $query .= " AND program = '$program'";
if (!empty($semester)) $query .= " AND semester = '$semester'";
if (!empty($course)) $query .= " AND course = '$course'";
if (!empty($document_type)) $query .= " AND document_type = '$document_type'";

$result = null;
if ($degree_level || $program || $semester || $course || $document_type) {
    $result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Library</title>

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

        .student-wrapper {
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

        .filter-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .documents-table {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .table-custom {
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
        }

        .table-custom thead {
            background-color: var(--color-primary);
            color: white;
        }

        .table-custom thead th {
            border: none;
            padding: 1rem;
        }

        .table-custom tbody tr:hover {
            background-color: rgba(59, 130, 246, 0.05);
        }

        .btn-view {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all var(--transition-speed);
        }

        .btn-view:hover {
            transform: translateY(-2px);
        }

      
        @media (max-width: 992px) {
            .student-wrapper {
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
    <div class="student-wrapper">
        <div class="sidebar">
            <div class="sidebar-brand">
                <i class="ph-bold ph-graduation-cap"></i>
                <h2>Student Portal</h2>
            </div>

            <nav class="sidebar-nav">
                <a href="index.php">
                    <i class="ph-bold ph-house"></i>
                    Dashboard
                </a>
                <a href="view_documents.php" class="active">
                    <i class="ph-bold ph-file-text"></i>
                    Document Library
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
                    <h1 class="fw-bold">Document Library</h1>
                    <p class="text-muted">Browse and download your study materials</p>
                </div>
            </div>

            <div class="filter-card">
                <form method="GET" id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <select name="degree_level" class="form-control" id="degreeLevelSelect">
                                <option value="">Degree Level</option>
                                <option value="Undergraduate">Undergraduate</option>
                                <option value="Postgraduate">Postgraduate</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="program" class="form-control" id="programSelect">
                                <option value="">Program</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="semester" class="form-control" id="semesterSelect">
                                <option value="">Semester</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="course" class="form-control" id="courseSelect">
                                <option value="">Course</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="document_type" class="form-control">
                                <option value="">Document Type</option>
                                <option value="Notes">Notes</option>
                                <option value="Question Paper">Question Paper</option>
                                <option value="Syllabus">Syllabus</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ph-bold ph-funnel me-2"></i>Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <?php if ($result && mysqli_num_rows($result) > 0) { ?>
            <div class="documents-table">
                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>Degree Level</th>
                                <th>Program</th>
                                <th>Semester</th>
                                <th>Course</th>
                                <th>Document Type</th>
                                <th>File Name</th>
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
                                <td>
                                    <a href="../uploads/<?php echo urlencode($row['file_name']); ?>" 
                                       target="_blank" class="btn btn-sm btn-primary btn-view me-2">
                                        <i class="ph-bold ph-eye"></i> View
                                    </a>
                                    <a href="../uploads/<?php echo urlencode($row['file_name']); ?>" 
                                       download class="btn btn-sm btn-success btn-view">
                                        <i class="ph-bold ph-download"></i> Download
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php } else if ($degree_level || $program || $semester || $course || $document_type) { ?>
            <div class="alert alert-info text-center">
                No documents found matching your filters.
            </div>
            <?php } ?>
        </div>
    </div>

    <script>
        const programs = <?php echo json_encode($programs); ?>;
        const degreeLevelSelect = document.getElementById('degreeLevelSelect');
        const programSelect = document.getElementById('programSelect');
        const semesterSelect = document.getElementById('semesterSelect');
        const courseSelect = document.getElementById('courseSelect');

        function updatePrograms() {
            const selectedDegreeLevel = degreeLevelSelect.value;
            programSelect.innerHTML = '<option value="">Program</option>';
            semesterSelect.innerHTML = '<option value="">Semester</option>';
            courseSelect.innerHTML = '<option value="">Course</option>';
            
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
            semesterSelect.innerHTML = '<option value="">Semester</option>';
            courseSelect.innerHTML = '<option value="">Course</option>';
            
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
            courseSelect.innerHTML = '<option value="">Course</option>';
            
            if (selectedDegreeLevel && selectedProgram && selectedSemester && programs[selectedDegreeLevel][selectedProgram]) {
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>