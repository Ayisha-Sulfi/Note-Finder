<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Vault - Your Learning Companion</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        :root {
            --primary-color: #6a60e6;
            --secondary-color: #6a60e7c4;
            --accent-color: #E6E6FA;
            --text-color: #ffffff;
            --transition: all 0.3s ease;
        }

        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            z-index: -2;
        }

        .geometric-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.1;
        }

        .shape {
            position: absolute;
            background-color: var(--accent-color);
        }

        .circle {
            border-radius: 50%;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }

        .logo {
            font-weight: bold;
            font-size: 28px;
            background: linear-gradient(45deg, var(--accent-color), #ffffff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 2s infinite linear;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        nav ul {
            list-style-type: none;
            display: flex;
            gap: 30px;
        }

        nav ul li a {
            color: var(--text-color);
            text-decoration: none;
            transition: var(--transition);
            font-weight: 500;
            position: relative;
        }

        nav ul li a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--accent-color);
            transition: var(--transition);
        }

        nav ul li a:hover::after {
            width: 100%;
        }

        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 200px);
        }

        .content-wrapper {
            display: flex;
            align-items: center;
            gap: 50px;
        }

        .text-content {
            max-width: 600px;
        }

        .features-section {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }

        .feature {
            text-align: center;
            max-width: 250px;
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 10px;
            transition: var(--transition);
        }

        .feature:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .feature i {
            font-size: 48px;
            color: var(--accent-color);
            margin-bottom: 15px;
        }

        h1 {
            font-size: 56px;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        p {
            margin-bottom: 30px;
            font-size: 18px;
            line-height: 1.6;
        }

        .buttons {
            display: flex;
            gap: 20px;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background: var(--accent-color);
            color: var(--primary-color);
        }

        .btn-secondary {
            background-color: transparent;
            border: 2px solid var(--accent-color);
            color: var(--accent-color);
        }

        .login-section {
            display: flex;
            gap: 20px;
            margin-top: 30px;
        }

        .login-btn {
            background: rgba(255,255,255,0.1);
            color: var(--text-color);
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            flex-grow: 1;
            transition: var(--transition);
        }

        .login-btn:hover {
            background: rgba(255,255,255,0.2);
            transform: scale(1.05);
        }

        .login-btn i {
            display: block;
            font-size: 36px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="background"></div>
    <div class="geometric-shapes"></div>
    <div class="container">
        <header>
            <div class="logo">Academic Vault.</div>
            <nav>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Features</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
        </header>

        <main class="main-content">
            <div class="content-wrapper">
                <div class="text-content">
                    <h1>Your Academic Success Starts Here</h1>
                    <p>Academic Vault is your comprehensive platform for accessing previous year question papers, detailed study notes, comprehensive syllabi, and essential academic resources tailored for undergraduate and postgraduate students.</p>
                    
                    <div class="login-section">
                        <a href="login/student_login.php" class="login-btn">
                            <i class="fas fa-graduation-cap"></i>
                            Student Login
                        </a>
                        <a href="login/faculty_login.php" class="login-btn">
                            <i class="fas fa-chalkboard-teacher"></i>
                            Faculty Login
                        </a>
                        <a href="login/admin_login.php" class="login-btn">
                            <i class="fas fa-user-shield"></i>
                            Admin Login
                        </a>
                    </div>
                </div>
            </div>
        </main>

        <section class="features-section">
            <div class="feature">
                <i class="fas fa-file-alt"></i>
                <h3>Question Papers</h3>
                <p>Access previous years' question papers to understand exam patterns and improve preparation.</p>
            </div>
            <div class="feature">
                <i class="fas fa-book-open"></i>
                <h3>Study Notes</h3>
                <p>Comprehensive and curated study materials created by experienced educators.</p>
            </div>
            <div class="feature">
                <i class="fas fa-clipboard-list"></i>
                <h3>Syllabus</h3>
                <p>Up-to-date syllabi for various courses to guide your academic journey.</p>
            </div>
        </section>
    </div>

    <script>
        function createShapes() {
            const shapesContainer = document.querySelector('.geometric-shapes');
            const shapeCount = 20;

            for (let i = 0; i < shapeCount; i++) {
                const shape = document.createElement('div');
                shape.classList.add('shape');
                
                if (Math.random() > 0.5) {
                    shape.classList.add('circle');
                }
                
                const size = Math.random() * 100 + 50;
                shape.style.width = `${size}px`;
                shape.style.height = `${size}px`;
                
                shape.style.left = `${Math.random() * 100}vw`;
                shape.style.top = `${Math.random() * 100}vh`;
                
                shape.style.opacity = Math.random() * 0.5 + 0.1;
                
                shapesContainer.appendChild(shape);
            }
        }

        createShapes();
    </script>
</body>
</html>