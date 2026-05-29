<?php
// Enhanced XSS Protection and Security Headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' https: data:;");

// Start session with secure settings
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.use_strict_mode', 1);
session_start();

// XSS Protection Functions
function sanitizeOutput($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// CSRF Protection
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// Load programme data from JSON file
function loadProgrammeData() {
    $jsonFile = 'programmes.json';
    if (file_exists($jsonFile)) {
        $jsonContent = file_get_contents($jsonFile);
        $data = json_decode($jsonContent, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $data;
        }
    }
    return null;
}

// Get programme ID from URL parameter with validation
$programmeId = '';
if (isset($_GET['id'])) {
    $programmeId = sanitizeInput($_GET['id']);
}

// Load programme data
$programmeData = loadProgrammeData();
$currentProgramme = null;

if ($programmeData && $programmeId && isset($programmeData[$programmeId])) {
    $currentProgramme = $programmeData[$programmeId];
}

// Handle form submissions
$registerMessage = '';
$withdrawMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed');
    }
    
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'register') {
            $studentName = sanitizeInput($_POST['student_name'] ?? '');
            $studentEmail = filter_var($_POST['student_email'] ?? '', FILTER_SANITIZE_EMAIL);
            
            if (!empty($studentName) && filter_var($studentEmail, FILTER_VALIDATE_EMAIL)) {
                // Here you would typically save to database
                $registerMessage = "Interest registered successfully for " . sanitizeOutput($studentName);
            } else {
                $registerMessage = "Please provide valid name and email";
            }
        } elseif ($_POST['action'] === 'withdraw') {
            $studentEmail = filter_var($_POST['withdraw_email'] ?? '', FILTER_SANITIZE_EMAIL);
            
            if (filter_var($studentEmail, FILTER_VALIDATE_EMAIL)) {
                // Here you would typically remove from database
                $withdrawMessage = "Interest withdrawn successfully";
            } else {
                $withdrawMessage = "Please provide a valid email";
            }
        }
    }
}

$page_title = $currentProgramme ? sanitizeOutput($currentProgramme['name']) . ' - University' : 'Programme Not Found - University';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        .programme-header {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
            position: relative;
        }
        
        .programme-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.4);
        }
        
        .programme-header h1 {
            position: relative;
            z-index: 1;
            font-size: 2.5em;
            margin: 0;
            text-align: center;
        }
        
        .programme-details {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .programme-section {
            margin: 30px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .programme-section h2, .programme-section h3 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        
        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .year-modules {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .year-modules h4 {
            color: #007bff;
            margin-top: 0;
            font-size: 1.2em;
        }
        
        .year-modules ul {
            list-style-type: none;
            padding: 0;
        }
        
        .year-modules li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        
        .year-modules li:last-child {
            border-bottom: none;
        }
        
        .form-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #ddd;
        }
        
        .form-section label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .form-section input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        
        .form-section button {
            background: #007bff;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }
        
        .form-section button:hover {
            background: #0056b3;
        }
        
        .message {
            margin: 15px 0;
            padding: 10px;
            border-radius: 4px;
            font-weight: bold;
        }
        
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .message.info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        .error-page {
            text-align: center;
            padding: 60px 20px;
        }
        
        .error-page h2 {
            color: #dc3545;
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .modules-grid {
                grid-template-columns: 1fr;
            }
            
            .programme-header h1 {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo-container">
            <a href="index1.php">
                <img src="https://i.fbcd.co/products/resized/resized-1500-1000/university-logo-converted-01-45c1f69249d8d113e17549c483a945debce48c771b5a4bcdf54fd6f890833276.webp" alt="University Logo" class="logo">
            </a>
            <span class="logo-text">Student Course Hub</span>
        </div>    
        <nav>
            <a href="modules.php">Modules</a>
            <a href="staff.php">Staff</a>
            <?php if ($isLoggedIn): ?>
                <a href="admin_dashboard.php" id="admin-dashboard-link">Admin Dashboard</a>
                <a href="logout.php" id="logout-link">Logout</a>
            <?php else: ?>
                <a href="admin_login.php" id="login-link">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <?php if ($currentProgramme): ?>
        <section class="programme-header" id="programme-header" 
                 style="background-image: url('<?php echo sanitizeOutput($currentProgramme['image']); ?>');">
            <h1 id="programme-name"><?php echo sanitizeOutput($currentProgramme['name']); ?></h1>
        </section>

        <main class="programme-details">
            <section class="programme-section">
                <h2>About this Programme</h2>
                <p id="programme-description"><?php echo sanitizeOutput($currentProgramme['description']); ?></p>
            </section>

            <section class="programme-section">
                <h3>Programme Leader</h3>
                <p id="programme-leader"><?php echo sanitizeOutput($currentProgramme['leader']); ?></p>
            </section>

            <section class="programme-section">
                <h3>Programme Modules</h3>
                <div class="modules-grid">
                    <?php foreach ($currentProgramme['modules'] as $year => $modules): ?>
                        <div class="year-modules">
                            <h4><?php echo ucfirst(str_replace('year', 'Year ', $year)); ?> Modules</h4>
                            <ul id="modules-<?php echo $year; ?>">
                                <?php foreach ($modules as $module): ?>
                                    <li><?php echo sanitizeOutput($module); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <section class="programme-section">
                <h3>Register Your Interest</h3>
                
                <?php if ($registerMessage): ?>
                    <div class="message success"><?php echo sanitizeOutput($registerMessage); ?></div>
                <?php endif; ?>
                
                <div class="form-section">
                    <form id="register-form" method="POST" action="">
                        <input type="hidden" name="csrf_token" value="<?php echo sanitizeOutput($_SESSION['csrf_token']); ?>">
                        <input type="hidden" name="action" value="register">
                        
                        <label for="student-name">Full Name:</label>
                        <input type="text" id="student-name" name="student_name" required maxlength="100">
                
                        <label for="student-email">Email:</label>
                        <input type="email" id="student-email" name="student_email" required maxlength="255">
                
                        <button type="submit">Register Interest</button>
                    </form>
                </div>

                <h4>Withdraw Interest</h4>
                
                <?php if ($withdrawMessage): ?>
                    <div class="message info"><?php echo sanitizeOutput($withdrawMessage); ?></div>
                <?php endif; ?>
                
                <div class="form-section">
                    <form id="withdraw-form" method="POST" action="">
                        <input type="hidden" name="csrf_token" value="<?php echo sanitizeOutput($_SESSION['csrf_token']); ?>">
                        <input type="hidden" name="action" value="withdraw">
                        
                        <label for="withdraw-email">Email:</label>
                        <input type="email" id="withdraw-email" name="withdraw_email" required maxlength="255">
                        
                        <button type="submit" id="withdraw-button">Withdraw Interest</button>
                    </form>
                </div>
            </section>
        </main>
    <?php else: ?>
        <main class="programme-details">
            <div class="error-page">
                <h2>Programme Not Found</h2>
                <p>The requested programme could not be found. Please check the URL or return to the <a href="index1.php">homepage</a>.</p>
            </div>
        </main>
    <?php endif; ?>

    <script>
        // Enhanced client-side functionality with JSON data integration
        document.addEventListener('DOMContentLoaded', function() {
            const programmeId = "<?php echo $programmeId; ?>";
            const registerForm = document.getElementById('register-form');
            const withdrawForm = document.getElementById('withdraw-form');
            
            // Enhanced form validation
            if (registerForm) {
                registerForm.addEventListener('submit', function(e) {
                    const name = document.getElementById('student-name').value.trim();
                    const email = document.getElementById('student-email').value.trim();
                    
                    if (name.length < 2) {
                        e.preventDefault();
                        alert('Please provide a valid name (at least 2 characters)');
                        return;
                    }
                    
                    if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                        e.preventDefault();
                        alert('Please provide a valid email address');
                        return;
                    }
                    
                    // Optional: Check for duplicate registrations (client-side only)
                    let storedRegistrations = JSON.parse(localStorage.getItem("registeredProgrammes")) || {};
                    if (storedRegistrations[programmeId]) {
                        const alreadyRegistered = storedRegistrations[programmeId].some(
                            (entry) => entry.email === email
                        );
                        
                        if (alreadyRegistered) {
                            e.preventDefault();
                            alert('You have already registered interest for this programme.');
                            return;
                        }
                    }
                    
                    // Store registration locally for consistency with original functionality
                    if (!storedRegistrations[programmeId]) {
                        storedRegistrations[programmeId] = [];
                    }
                    storedRegistrations[programmeId].push({ name: name, email: email });
                    localStorage.setItem("registeredProgrammes", JSON.stringify(storedRegistrations));
                });
            }
            
            if (withdrawForm) {
                withdrawForm.addEventListener('submit', function(e) {
                    const email = document.getElementById('withdraw-email').value.trim();
                    
                    if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                        e.preventDefault();
                        alert('Please provide a valid email address');
                        return;
                    }
                    
                    if (!confirm('Are you sure you want to withdraw your interest?')) {
                        e.preventDefault();
                        return;
                    }
                    
                    // Remove from localStorage for consistency
                    let storedRegistrations = JSON.parse(localStorage.getItem("registeredProgrammes")) || {};
                    if (storedRegistrations[programmeId]) {
                        const index = storedRegistrations[programmeId].findIndex(entry => entry.email === email);
                        if (index !== -1) {
                            storedRegistrations[programmeId].splice(index, 1);
                            localStorage.setItem("registeredProgrammes", JSON.stringify(storedRegistrations));
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>