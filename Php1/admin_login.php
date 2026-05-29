<?php
// Enhanced XSS Protection and Security Headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' https://i.fbcd.co;");

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

// Rate limiting for login attempts
function checkRateLimit() {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $key = 'login_attempts_' . $ip;
    
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = ['count' => 0, 'time' => time()];
    }
    
    $attempts = $_SESSION[$key];
    
    // Reset if more than 15 minutes have passed
    if (time() - $attempts['time'] > 900) {
        $_SESSION[$key] = ['count' => 0, 'time' => time()];
        return true;
    }
    
    // Block if more than 5 attempts in 15 minutes
    if ($attempts['count'] >= 5) {
        return false;
    }
    
    return true;
}

function recordFailedAttempt() {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $key = 'login_attempts_' . $ip;
    
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = ['count' => 0, 'time' => time()];
    }
    
    $_SESSION[$key]['count']++;
    $_SESSION[$key]['time'] = time();
}

// Check if user is already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin_dashboard.php');
    exit;
}

$loginMessage = '';
$loginError = '';

// Handle form submission, checks if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check rate limiting
    if (!checkRateLimit()) {
        $loginError = 'Too many failed attempts. Please try again in 15 minutes.';
    } else {
        // Verify CSRF token
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $loginError = 'Security token validation failed. Please try again.';
        } else {
            $username = sanitizeInput($_POST['username'] ?? '');
            $password = $_POST['password'] ?? ''; // Don't sanitize password as it might contain special chars
            
            // Validate credentials
            if (authenticateAdmin($username, $password)) {
                // Regenerate session ID to prevent session fixation
                session_regenerate_id(true);
                
                // Set session variables
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $username;
                $_SESSION['login_time'] = time();
                
                // Generate new CSRF token
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                
                // Log successful login (in production, log to file)
                error_log("Admin login successful for user: $username from IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
                
                // Redirect to dashboard
                header('Location: admin_dashboard.php');
                exit;
            } else {
                recordFailedAttempt();
                $loginError = 'Invalid username or password. Please try again.';
                
                // Log failed attempt (in production, log to file)
                error_log("Admin login failed for user: $username from IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
            }
        }
    }
}

// Simple authentication function (in production, use proper password hashing and database)
function authenticateAdmin($username, $password) {
    // In production, replace with database lookup and password_verify()
    $validCredentials = [
        'admin' => password_hash('password123', PASSWORD_DEFAULT)
    ];
    
    if (isset($validCredentials[$username])) {
        return password_verify($password, $validCredentials[$username]);
    }
    
    return false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Student Course Hub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <a href="index1.php">
                <img src="https://i.fbcd.co/products/resized/resized-1500-1000/university-logo-converted-01-45c1f69249d8d113e17549c483a945debce48c771b5a4bcdf54fd6f890833276.webp" alt="University Logo" class="logo">
            </a>
            <span class="logo-text">Student Course Hub - Admin</span>
        </div>
    </header>

    <main>
        <section>
            <h2>Administrator Login</h2>
            
            <?php if ($loginError): ?>
                <div class="error-message" style="color: red; margin-bottom: 20px; padding: 10px; border: 1px solid red; border-radius: 4px; background-color: #ffe6e6;">
                    <?php echo sanitizeOutput($loginError); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($loginMessage): ?>
                <div class="success-message" style="color: green; margin-bottom: 20px; padding: 10px; border: 1px solid green; border-radius: 4px; background-color: #e6ffe6;">
                    <?php echo sanitizeOutput($loginMessage); ?>
                </div>
            <?php endif; ?>
            
            <form id="admin-login-form" method="POST" action="" autocomplete="off">
                <input type="hidden" name="csrf_token" value="<?php echo sanitizeOutput($_SESSION['csrf_token']); ?>">
                
                <label for="admin-username">Username:</label>
                <input type="text" 
                       id="admin-username" 
                       name="username" 
                       required 
                       maxlength="50"
                       autocomplete="username"
                       value="<?php echo isset($_POST['username']) ? sanitizeOutput($_POST['username']) : ''; ?>">

                <label for="admin-password">Password:</label>
                <input type="password" 
                       id="admin-password" 
                       name="password" 
                       required 
                       maxlength="100"
                       autocomplete="current-password">

                <button type="submit">Login</button>
                
                <div class="login-info" style="margin-top: 20px; font-size: 0.9em; color: #666;">
                    <p><strong>Demo Credentials:</strong></p>
                    <p>Username: admin</p>
                    <p>Password: password123</p>
                </div>
            </form>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('admin-login-form');
            const usernameInput = document.getElementById('admin-username');
            const passwordInput = document.getElementById('admin-password');

            // Client-side validation
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    const username = usernameInput.value.trim();
                    const password = passwordInput.value;
                    
                    // Basic validation
                    if (username.length < 3) {
                        e.preventDefault();
                        alert('Username must be at least 3 characters long');
                        usernameInput.focus();
                        return;
                    }
                    
                    if (password.length < 6) {
                        e.preventDefault();
                        alert('Password must be at least 6 characters long');
                        passwordInput.focus();
                        return;
                    }
                    
                    // Show loading state
                    const submitButton = loginForm.querySelector('button[type="submit"]');
                    submitButton.disabled = true;
                    submitButton.textContent = 'Logging in...';
                    
                    // Form will submit normally to PHP
                });
            }

            // Clear any existing localStorage admin tokens when on login page
            if (localStorage.getItem('adminToken')) {
                localStorage.removeItem('adminToken');
            }

            // Focus on username field
            if (usernameInput && !usernameInput.value) {
                usernameInput.focus();
            } else if (passwordInput) {
                passwordInput.focus();
            }

            // Password visibility toggle (optional enhancement)
            const togglePassword = document.createElement('button');
            togglePassword.type = 'button';
            togglePassword.textContent = '👁️';
            togglePassword.style.cssText = 'position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border: none; background: none; cursor: pointer; font-size: 16px;';
            
            const passwordContainer = document.createElement('div');
            passwordContainer.style.position = 'relative';
            passwordContainer.style.display = 'inline-block';
            passwordContainer.style.width = '100%';
            
            passwordInput.parentNode.insertBefore(passwordContainer, passwordInput);
            passwordContainer.appendChild(passwordInput);
            passwordContainer.appendChild(togglePassword);
            
            togglePassword.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    togglePassword.textContent = '🙈';
                } else {
                    passwordInput.type = 'password';
                    togglePassword.textContent = '👁️';
                }
            });
        });
    </script>
</body>
</html>