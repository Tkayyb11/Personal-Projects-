<?php
// Enhanced XSS Protection and Security Headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' https://th.bing.com https://www.scorpiotankers.com https://olphna.org https://images.law.com https://www.acli.com https://childressagency.com https://www.think2perform.com;");

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

// Staff data array - in real application, this would come from a database
$staffMembers = [
    [
        'name' => 'Dr. Alice Johnson',
        'department' => 'Computer Science Department',
        'email' => 'alice.johnson@university.edu',
        'phone' => '+447397462894',
        'image' => 'https://th.bing.com/th/id/OIP.FEp3o0ESgjvieXCiGYfiBQAAAA?rs=1&pid=ImgDetMain',
        'type' => 'faculty'
    ],
    [
        'name' => 'Dr. Brian Lee',
        'department' => 'Mathematics Department',
        'email' => 'brian.lee@university.edu',
        'phone' => '+447298374583',
        'image' => 'https://www.scorpiotankers.com/wp-content/uploads/2022/12/Brian-Lee-1.jpg',
        'type' => 'faculty'
    ],
    [
        'name' => 'Dr. Carol White',
        'department' => 'Computer Systems Department',
        'email' => 'carol.white@university.edu',
        'phone' => '+447304857689',
        'image' => 'https://olphna.org/images/stories/auto-extract/white-carol-409_resized.jpg',
        'type' => 'faculty'
    ],
    [
        'name' => 'Dr. David Green',
        'department' => 'Database Systems Department',
        'email' => 'david.green@university.edu',
        'phone' => '+447390285621',
        'image' => 'https://images.law.com/contrib/content/uploads/sites/378/2021/10/David-Green_14016-767x633.jpg',
        'type' => 'faculty'
    ],
    [
        'name' => 'Dr. Emma Scott',
        'department' => 'Software Engineering Department',
        'email' => 'emma.scott@university.edu',
        'phone' => '+445839875091',
        'image' => 'https://th.bing.com/th/id/OIP.65KxdYPA3mxJkwRi-AB3TQHaLH?rs=1&pid=ImgDetMain',
        'type' => 'faculty'
    ],
    [
        'name' => 'Dr. Frank Moore',
        'department' => 'Algorithms Department',
        'email' => 'frank.moore@university.edu',
        'phone' => '+447294680924',
        'image' => 'https://www.acli.com/-/media/acli/leadership/graham.jpg?h=350&w=400&la=en&hash=EE09C673BF116BD7784356C9F2F075C0',
        'type' => 'faculty'
    ],
    [
        'name' => 'Dr. Grace Adams',
        'department' => 'Cyber Security Department',
        'email' => 'grace.adams@university.edu',
        'phone' => '+448390476894',
        'image' => 'https://childressagency.com/wp-content/uploads/2023/05/irene-borys.jpg',
        'type' => 'faculty'
    ],
    [
        'name' => 'Dr. Henry Clark',
        'department' => 'Artificial Intelligence Department',
        'email' => 'henry.clark@university.edu',
        'phone' => '+442898736592',
        'image' => 'https://www.think2perform.com/wp-content/uploads/2022/09/dave-meldahl.png',
        'type' => 'faculty'
    ],
    [
        'name' => 'Dr. Irene Hall',
        'department' => 'Machine Learning Department',
        'email' => 'irene.hall@university.edu',
        'phone' => '+447693803987',
        'image' => 'https://th.bing.com/th/id/OIP.RED3ciDTwZ8RqiUrOvA6-wAAAA?rs=1&pid=ImgDetMain',
        'type' => 'faculty'
    ],
    // Administration staff examples
    [
        'name' => 'Sarah Wilson',
        'department' => 'Student Services',
        'email' => 'sarah.wilson@university.edu',
        'phone' => '+447123456789',
        'image' => 'https://th.bing.com/th/id/OIP.FEp3o0ESgjvieXCiGYfiBQAAAA?rs=1&pid=ImgDetMain',
        'type' => 'administration'
    ],
    [
        'name' => 'Mark Thompson',
        'department' => 'IT Services',
        'email' => 'mark.thompson@university.edu',
        'phone' => '+447987654321',
        'image' => 'https://www.acli.com/-/media/acli/leadership/graham.jpg?h=350&w=400&la=en&hash=EE09C673BF116BD7784356C9F2F075C0',
        'type' => 'administration'
    ]
];

// Handle search/filter parameters
$searchTerm = '';
$filterType = '';
if (isset($_GET['search'])) {
    $searchTerm = sanitizeInput($_GET['search']);
}
if (isset($_GET['type'])) {
    $filterType = sanitizeInput($_GET['type']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Staff Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="staff-header">
        <div class="staff-logo-container">
            <a href="index1.php">
                <img src="https://i.fbcd.co/products/resized/resized-1500-1000/university-logo-converted-01-45c1f69249d8d113e17549c483a945debce48c771b5a4bcdf54fd6f890833276.webp" alt="University Logo" class="staff-logo">
            </a>
            <span class="staff-logo-text">Staff Portal</span>
        </div>    
        <nav class="staff-nav">
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

    <main class="staff-container">
        <section class="staff-filter">
            <h2>Filter</h2>
            <label>
                <input type="checkbox" id="staff-faculty" value="faculty" checked> Faculty
            </label>
            <label>
                <input type="checkbox" id="staff-administration" value="administration" checked> Administration
            </label>
            
            <!-- Search functionality -->
            <div class="search-container">
                <input type="text" id="staff-search" placeholder="Search staff members..." value="<?php echo sanitizeOutput($searchTerm); ?>">
            </div>
        </section>

        <section class="staff-programmes">
            <h2>Staff Directory</h2>
            <div class="staff-programme-list">
                <?php foreach ($staffMembers as $staff): ?>
                    <div class="staff-programme" data-type="<?php echo sanitizeOutput($staff['type']); ?>">
                        <div class="staff-faculty-header">
                            <img src="<?php echo sanitizeOutput($staff['image']); ?>" 
                                 alt="<?php echo sanitizeOutput($staff['name']); ?>" 
                                 onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22 viewBox=%220 0 100 100%22><rect width=%22100%22 height=%22100%22 fill=%22%23f0f0f0%22/><text x=%2250%22 y=%2250%22 text-anchor=%22middle%22 dy=%22.3em%22 font-family=%22Arial%22 font-size=%2212%22 fill=%22%23666%22>No Image</text></svg>'">
                            <h3><?php echo sanitizeOutput($staff['name']); ?></h3>
                            <p><?php echo sanitizeOutput($staff['department']); ?></p>
                        </div>
                        <div class="staff-faculty-contact">
                            <p>📧 <a href="mailto:<?php echo sanitizeOutput($staff['email']); ?>"><?php echo sanitizeOutput($staff['email']); ?></a></p>
                            <p>📞 <a href="tel:<?php echo sanitizeOutput($staff['phone']); ?>"><?php echo sanitizeOutput($staff['phone']); ?></a></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.staff-filter input[type="checkbox"]');
            const staffMembers = document.querySelectorAll('.staff-programme');
            const searchInput = document.getElementById('staff-search');

            // Function to update staff visibility based on filters and search
            function updateStaffVisibility() {
                const selectedTypes = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);
                const searchTerm = searchInput.value.toLowerCase().trim();

                staffMembers.forEach(staff => {
                    const staffType = staff.getAttribute('data-type');
                    const staffName = staff.querySelector('h3').textContent.toLowerCase();
                    const staffDepartment = staff.querySelector('p').textContent.toLowerCase();
                    const staffEmail = staff.querySelector('.staff-faculty-contact a').textContent.toLowerCase();
                    
                    const matchesType = selectedTypes.includes(staffType);
                    const matchesSearch = !searchTerm || 
                        staffName.includes(searchTerm) || 
                        staffDepartment.includes(searchTerm) || 
                        staffEmail.includes(searchTerm);
                    
                    staff.style.display = (matchesType && matchesSearch) ? "block" : "none";
                });
            }

            // Event listeners for filters
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", updateStaffVisibility);
            });

            // Event listener for search
            searchInput.addEventListener("input", updateStaffVisibility);

            // Initialize visibility
            updateStaffVisibility();

            // Login status management (keeping original functionality)
            const loginLink = document.getElementById('login-link');
            const logoutLink = document.getElementById('logout-link');
            const adminDashboardLink = document.getElementById('admin-dashboard-link');

            function checkLoginStatus() {
                // In PHP version, this is handled server-side, but keeping for compatibility
                // if you still want client-side localStorage functionality
                const adminToken = localStorage.getItem('adminToken');
                if (adminToken && !<?php echo $isLoggedIn ? 'true' : 'false'; ?>) {
                    // Client-side token exists but server-side session doesn't
                    localStorage.removeItem('adminToken');
                }
            }

            checkLoginStatus();

            if (logoutLink) {
                logoutLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    localStorage.removeItem('adminToken');
                    window.location.href = 'logout.php';
                });
            }
        });
    </script>
</body>
</html>