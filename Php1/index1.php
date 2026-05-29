<?php


// Enhanced XSS Protection and Security Headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' https://i.fbcd.co https://onlinecourseing.com https://wallpaperaccess.com https://www.udacity.com https://www.york.ac.uk https://www.cdmi.in https://theconstructor.org;");

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

// Programme data array - come from a database
$programmes = [
    [
        'id' => 'bsc-computer-science',
        'name' => 'BSc Computer Science',
        'level' => 'undergraduate',
        'image' => 'https://onlinecourseing.com/wp-content/uploads/2021/11/15-Best-Computer-Science-Courses-Online-for-Beginners.jpg',
        'description' => 'A comprehensive programme covering all aspects of computer science, from programming fundamentals to advanced algorithms and system design.'
    ],
    [
        'id' => 'bsc-software-engineering',
        'name' => 'BSc Software Engineering',
        'level' => 'undergraduate',
        'image' => 'https://wallpaperaccess.com/full/3632441.jpg',
        'description' => 'Focus on the systematic approach to software development, including design patterns, testing, and project management.'
    ],
    [
        'id' => 'bsc-artificial-intelligence',
        'name' => 'BSc Artificial Intelligence',
        'level' => 'undergraduate',
        'image' => 'https://www.udacity.com/blog/wp-content/uploads/2021/03/Advanced-AI-Courses_Blog.jpeg',
        'description' => 'Explore the fascinating world of AI, including machine learning, neural networks, and intelligent systems.'
    ],
    [
        'id' => 'bsc-cyber-security',
        'name' => 'BSc Cyber Security',
        'level' => 'undergraduate',
        'image' => 'https://www.york.ac.uk/media/study/courses/postgraduate/computerscience/cyber%20security%20banner.jpg',
        'description' => 'Learn to protect digital assets with expertise in network security, ethical hacking, and digital forensics.'
    ],
    [
        'id' => 'bsc-data-science',
        'name' => 'BSc Data Science',
        'level' => 'undergraduate',
        'image' => 'https://www.cdmi.in/courses@2x/data-science.webp',
        'description' => 'Master the art of extracting insights from data using statistical analysis, machine learning, and visualization.'
    ],
    [
        'id' => 'msc-machine-learning',
        'name' => 'MSc Machine Learning',
        'level' => 'postgraduate',
        'image' => 'https://theconstructor.org/wp-content/uploads/2021/05/ML1-scaled.jpg',
        'description' => 'Advanced study of machine learning algorithms, deep learning, and artificial intelligence applications.'
    ],
    [
        'id' => 'msc-cyber-security',
        'name' => 'MSc Cyber Security',
        'level' => 'postgraduate',
        'image' => 'https://www.york.ac.uk/media/study/courses/postgraduate/computerscience/cyber%20security%20banner.jpg',
        'description' => 'Advanced cybersecurity concepts including threat intelligence, incident response, and security architecture.'
    ],
    [
        'id' => 'msc-data-science',
        'name' => 'MSc Data Science',
        'level' => 'postgraduate',
        'image' => 'https://www.cdmi.in/courses@2x/data-science.webp',
        'description' => 'Advanced data science techniques, big data analytics, and AI-driven insights for complex business problems.'
    ],
    [
        'id' => 'msc-artificial-intelligence',
        'name' => 'MSc Artificial Intelligence',
        'level' => 'postgraduate',
        'image' => 'https://www.udacity.com/blog/wp-content/uploads/2021/03/Advanced-AI-Courses_Blog.jpeg',
        'description' => 'Cutting-edge AI research, neural networks, natural language processing, and autonomous systems.'
    ],
    [
        'id' => 'msc-software-engineering',
        'name' => 'MSc Software Engineering',
        'level' => 'postgraduate',
        'image' => 'https://wallpaperaccess.com/full/3632441.jpg',
        'description' => 'Advanced software engineering practices, distributed systems, cloud computing, and enterprise architecture.'
    ]
];

// Handle search parameters
$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = sanitizeInput($_GET['search']);
}

// Filter programmes based on search if provided
$filteredProgrammes = $programmes;
if (!empty($searchTerm)) {
    $filteredProgrammes = array_filter($programmes, function($programme) use ($searchTerm) {
        return stripos($programme['name'], $searchTerm) !== false ||
               stripos($programme['description'], $searchTerm) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Course Hub</title>
    <link rel="stylesheet" href="style.css">
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

    <main>
        <section class="filter">
            <h2>Filter</h2>
            <label>
                <input type="checkbox" id="undergraduate" value="undergraduate" checked> Undergraduate
            </label>
            <label>
                <input type="checkbox" id="postgraduate" value="postgraduate" checked> Postgraduate
            </label>
            <section class="search-container">
                <input type="text" id="search-bar" placeholder="Search for a programme..." value="<?php echo sanitizeOutput($searchTerm); ?>">
            </section>
        </section>

        <section class="programmes">
            <h2>Programmes</h2>
            <div class="programme-list">
                <?php foreach ($filteredProgrammes as $programme): ?>
                    <div class="programme" data-level="<?php echo sanitizeOutput($programme['level']); ?>">
                        <a href="programme_details.php?id=<?php echo urlencode($programme['id']); ?>" title="<?php echo sanitizeOutput($programme['description']); ?>">
                            <img src="<?php echo sanitizeOutput($programme['image']); ?>" 
                                 alt="<?php echo sanitizeOutput($programme['name']); ?>"
                                 onerror="this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22300%22 height=%22200%22 viewBox=%220 0 300 200%22><rect width=%22300%22 height=%22200%22 fill=%22%23f0f0f0%22/><text x=%22150%22 y=%22100%22 text-anchor=%22middle%22 dy=%22.3em%22 font-family=%22Arial%22 font-size=%2216%22 fill=%22%23666%22>Programme Image</text></svg>'">
                            <h3><?php echo sanitizeOutput($programme['name']); ?></h3>
                        </a>
                    </div>
                <?php endforeach; ?>
                
                <?php if (empty($filteredProgrammes)): ?>
                    <div class="no-results">
                        <p>No programmes found matching your search criteria.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.filter input[type="checkbox"]');
            const programmes = document.querySelectorAll('.programme');
            const searchBar = document.getElementById('search-bar');

            // Function to update programme visibility
            function updateProgrammeVisibility() {
                const selectedLevels = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);
                const searchTerm = searchBar.value.toLowerCase().trim();

                programmes.forEach(programme => {
                    const programmeName = programme.querySelector('h3').textContent.toLowerCase();
                    const programmeLevel = programme.getAttribute('data-level');
                    const programmeDescription = programme.querySelector('a').getAttribute('title').toLowerCase();
                    
                    const matchesLevel = selectedLevels.includes(programmeLevel);
                    const matchesSearch = !searchTerm || 
                        programmeName.includes(searchTerm) || 
                        programmeDescription.includes(searchTerm);
                    
                    programme.style.display = (matchesLevel && matchesSearch) ? "block" : "none";
                });

                // Show/hide no results message
                const visibleProgrammes = Array.from(programmes).filter(p => p.style.display !== "none");
                const noResultsDiv = document.querySelector('.no-results');
                if (noResultsDiv) {
                    noResultsDiv.style.display = visibleProgrammes.length === 0 ? "block" : "none";
                }
            }

            // Event listeners
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", updateProgrammeVisibility);
            });

            searchBar.addEventListener("input", updateProgrammeVisibility);

            // Initialize visibility
            updateProgrammeVisibility();

            // Login status management (hybrid approach)
            const loginLink = document.getElementById('login-link');
            const logoutLink = document.getElementById('logout-link');
            const adminDashboardLink = document.getElementById('admin-dashboard-link');

            function checkLoginStatus() {
                // Sync client-side localStorage with server-side session status
                const adminToken = localStorage.getItem('adminToken');
                const serverLoggedIn = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;
                
                if (adminToken && !serverLoggedIn) {
                    // Client thinks user is logged in but server doesn't - clear client state
                    localStorage.removeItem('adminToken');
                } else if (!adminToken && serverLoggedIn) {
                    // Server has session but client doesn't - this is fine, server takes precedence
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

            // Enhanced search functionality with URL updates
            let searchTimeout;
            searchBar.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    const searchValue = searchBar.value.trim();
                    const url = new URL(window.location);
                    if (searchValue) {
                        url.searchParams.set('search', searchValue);
                    } else {
                        url.searchParams.delete('search');
                    }
                    // Update URL without reloading page
                    window.history.replaceState({}, '', url);
                }, 300);
            });
        });
    </script>
</body>
</html>