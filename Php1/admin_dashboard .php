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

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

// CSRF Protection
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Initialize response array for AJAX requests
$response = ['success' => false, 'message' => ''];

// Sample programme data (in production, this would come from database)
$programmes = [
    [
        'id' => 'bsc-computer-science',
        'name' => 'BSc Computer Science',
        'level' => 'undergraduate',
        'status' => 'active',
        'created' => '2024-01-15'
    ],
    [
        'id' => 'bsc-software-engineering',
        'name' => 'BSc Software Engineering',
        'level' => 'undergraduate',
        'status' => 'active',
        'created' => '2024-01-15'
    ],
    [
        'id' => 'msc-machine-learning',
        'name' => 'MSc Machine Learning',
        'level' => 'postgraduate',
        'status' => 'active',
        'created' => '2024-01-15'
    ]
];

// Sample student registrations 
$studentRegistrations = [
    'bsc-computer-science' => [
        ['name' => 'John Smith', 'email' => 'john.smith@email.com', 'registered' => '2024-02-01'],
        ['name' => 'Emma Johnson', 'email' => 'emma.johnson@email.com', 'registered' => '2024-02-02'],
        ['name' => 'Michael Brown', 'email' => 'michael.brown@email.com', 'registered' => '2024-02-03']
    ],
    'bsc-software-engineering' => [
        ['name' => 'Sarah Davis', 'email' => 'sarah.davis@email.com', 'registered' => '2024-02-01'],
        ['name' => 'David Wilson', 'email' => 'david.wilson@email.com', 'registered' => '2024-02-02']
    ],
    'msc-machine-learning' => [
        ['name' => 'Lisa Anderson', 'email' => 'lisa.anderson@email.com', 'registered' => '2024-02-01'],
        ['name' => 'Robert Taylor', 'email' => 'robert.taylor@email.com', 'registered' => '2024-02-02'],
        ['name' => 'Jennifer White', 'email' => 'jennifer.white@email.com', 'registered' => '2024-02-03'],
        ['name' => 'Thomas Lee', 'email' => 'thomas.lee@email.com', 'registered' => '2024-02-04']
    ]
];

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'CSRF token validation failed']);
        exit;
    }
    
    $action = sanitizeInput($_POST['action'] ?? '');
    
    switch ($action) {
        case 'add_programme':
            $programmeName = sanitizeInput($_POST['programme_name'] ?? '');
            $programmeLevel = sanitizeInput($_POST['programme_level'] ?? '');
            
            if (empty($programmeName) || empty($programmeLevel)) {
                $response = ['success' => false, 'message' => 'Programme name and level are required'];
            } else {
                // In production, add to database
                $programmeId = strtolower(str_replace(' ', '-', $programmeName));
                $response = ['success' => true, 'message' => 'Programme added successfully', 'programme_id' => $programmeId];
                
                // Log the action
                error_log("Admin " . $_SESSION['admin_username'] . " added programme: $programmeName");
            }
            break;
            
        case 'delete_programme':
            $programmeId = sanitizeInput($_POST['programme_id'] ?? '');
            
            if (empty($programmeId)) {
                $response = ['success' => false, 'message' => 'Programme ID is required'];
            } else {
                // In production, delete from database
                $response = ['success' => true, 'message' => 'Programme deleted successfully'];
                
                // Log the action
                error_log("Admin " . $_SESSION['admin_username'] . " deleted programme: $programmeId");
            }
            break;
            
        case 'export_mailing_list':
            $programmeId = sanitizeInput($_POST['programme_id'] ?? '');
            
            if (empty($programmeId)) {
                $response = ['success' => false, 'message' => 'Programme ID is required'];
            } else {
                // In production, get from database
                $students = $studentRegistrations[$programmeId] ?? [];
                $emails = array_column($students, 'email');
                
                $response = [
                    'success' => true, 
                    'message' => 'Mailing list exported successfully',
                    'emails' => $emails,
                    'count' => count($emails)
                ];
                
                // Log the action
                error_log("Admin " . $_SESSION['admin_username'] . " exported mailing list for: $programmeId");
            }
            break;
            
        default:
            $response = ['success' => false, 'message' => 'Invalid action'];
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Handle GET requests for data
if (isset($_GET['action'])) {
    $action = sanitizeInput($_GET['action']);
    
    switch ($action) {
        case 'get_registrations':
            $programmeId = sanitizeInput($_GET['programme_id'] ?? '');
            $students = $studentRegistrations[$programmeId] ?? [];
            
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'data' => $students]);
            exit;
            
        case 'get_programmes':
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'data' => $programmes]);
            exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Student Course Hub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <a href="index1.php">
                <img src="https://i.fbcd.co/products/resized/resized-1500-1000/university-logo-converted-01-45c1f69249d8d113e17549c483a945debce48c771b5a4bcdf54fd6f890833276.webp" alt="University Logo" class="logo">
            </a>
            <span class="logo-text">Student Course Hub - Admin Dashboard</span>
        </div>
        <nav>
            <span class="admin-welcome">Welcome, <?php echo sanitizeOutput($_SESSION['admin_username']); ?>!</span>
            <a href="logout.php" id="admin-logout" class="btn-secondary">Logout</a>
        </nav>
    </header>

    <main id="admin-dashboard-main">
        <section>
            <h2>Programme Management</h2>
            <div id="programme-list">
                <?php foreach ($programmes as $programme): ?>
                    <div class="programme-item" data-id="<?php echo sanitizeOutput($programme['id']); ?>">
                        <div class="programme-info">
                            <h3><?php echo sanitizeOutput($programme['name']); ?></h3>
                            <p>Level: <?php echo sanitizeOutput(ucfirst($programme['level'])); ?></p>
                            <p>Status: <?php echo sanitizeOutput(ucfirst($programme['status'])); ?></p>
                            <p>Created: <?php echo sanitizeOutput($programme['created']); ?></p>
                        </div>
                        <div class="programme-actions">
                            <button class="btn-secondary edit-programme" data-id="<?php echo sanitizeOutput($programme['id']); ?>">Edit</button>
                            <button class="btn-danger delete-programme" data-id="<?php echo sanitizeOutput($programme['id']); ?>">Delete</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button id="add-programme-btn" class="btn-primary">Add New Programme</button>
        </section>

        <section>
            <h2>Student Registrations</h2>
            <select id="programme-select">
                <option value="">Select a Programme</option>
                <?php foreach ($programmes as $programme): ?>
                    <option value="<?php echo sanitizeOutput($programme['id']); ?>">
                        <?php echo sanitizeOutput($programme['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div id="student-registrations">
                <p>Select a programme to view registrations.</p>
            </div>
            <button id="export-mailing-list" class="btn-primary" disabled>Export Mailing List</button>
        </section>
    </main>

    <!-- Add Programme Modal -->
    <div id="add-programme-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Add New Programme</h3>
            <form id="add-programme-form">
                <input type="hidden" name="csrf_token" value="<?php echo sanitizeOutput($_SESSION['csrf_token']); ?>">
                <input type="hidden" name="action" value="add_programme">
                
                <label for="programme-name">Programme Name:</label>
                <input type="text" id="programme-name" name="programme_name" required maxlength="100">
                
                <label for="programme-level">Level:</label>
                <select id="programme-level" name="programme_level" required>
                    <option value="">Select Level</option>
                    <option value="undergraduate">Undergraduate</option>
                    <option value="postgraduate">Postgraduate</option>
                </select>
                
                <div class="modal-actions">
                    <button type="submit" class="btn-primary">Add Programme</button>
                    <button type="button" class="btn-secondary cancel-modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const programmeSelect = document.getElementById('programme-select');
            const studentRegistrations = document.getElementById('student-registrations');
            const exportButton = document.getElementById('export-mailing-list');
            const addProgrammeBtn = document.getElementById('add-programme-btn');
            const addProgrammeModal = document.getElementById('add-programme-modal');
            const addProgrammeForm = document.getElementById('add-programme-form');
            
            let currentProgrammeId = '';

            // Handle programme selection
            programmeSelect.addEventListener('change', function() {
                const programmeId = this.value;
                currentProgrammeId = programmeId;
                
                if (programmeId) {
                    loadRegistrations(programmeId);
                    exportButton.disabled = false;
                } else {
                    studentRegistrations.innerHTML = '<p>Select a programme to view registrations.</p>';
                    exportButton.disabled = true;
                }
            });

            // Load student registrations via AJAX
            function loadRegistrations(programmeId) {
                fetch(`?action=get_registrations&programme_id=${encodeURIComponent(programmeId)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            displayRegistrations(data.data);
                        } else {
                            studentRegistrations.innerHTML = '<p>Error loading registrations.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        studentRegistrations.innerHTML = '<p>Error loading registrations.</p>';
                    });
            }

            // Display student registrations
            function displayRegistrations(students) {
                if (students.length === 0) {
                    studentRegistrations.innerHTML = '<p>No students registered for this programme yet.</p>';
                    return;
                }

                let html = '<div class="registrations-table"><table><thead><tr><th>Name</th><th>Email</th><th>Registration Date</th></tr></thead><tbody>';
                
                students.forEach(student => {
                    html += `<tr>
                        <td>${escapeHtml(student.name)}</td>
                        <td><a href="mailto:${escapeHtml(student.email)}">${escapeHtml(student.email)}</a></td>
                        <td>${escapeHtml(student.registered)}</td>
                    </tr>`;
                });
                
                html += '</tbody></table></div>';
                html += `<p class="registration-count">Total registrations: ${students.length}</p>`;
                
                studentRegistrations.innerHTML = html;
            }

            // Export mailing list
            exportButton.addEventListener('click', function() {
                if (!currentProgrammeId) return;
                
                const formData = new FormData();
                formData.append('action', 'export_mailing_list');
                formData.append('programme_id', currentProgrammeId);
                formData.append('csrf_token', '<?php echo $_SESSION['csrf_token']; ?>');
                
                fetch('', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const emails = data.emails.join('\n');
                        const blob = new Blob([emails], { type: 'text/plain' });
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = `${currentProgrammeId}-mailing-list.txt`;
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        window.URL.revokeObjectURL(url);
                        
                        alert(`Mailing list exported successfully! (${data.count} emails)`);
                    } else {
                        alert('Error exporting mailing list: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error exporting mailing list');
                });
            });

            // Add Programme Modal
            addProgrammeBtn.addEventListener('click', function() {
                addProgrammeModal.style.display = 'block';
            });

            // Close modal
            document.querySelector('.close').addEventListener('click', function() {
                addProgrammeModal.style.display = 'none';
            });

            document.querySelector('.cancel-modal').addEventListener('click', function() {
                addProgrammeModal.style.display = 'none';
            });

            // Add programme form submission
            addProgrammeForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                fetch('', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        addProgrammeModal.style.display = 'none';
                        location.reload(); // Reload to show new programme
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error adding programme');
                });
            });

            // Delete programme functionality
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('delete-programme')) {
                    const programmeId = e.target.dataset.id;
                    
                    if (confirm('Are you sure you want to delete this programme? This action cannot be undone.')) {
                        const formData = new FormData();
                        formData.append('action', 'delete_programme');
                        formData.append('programme_id', programmeId);
                        formData.append('csrf_token', '<?php echo $_SESSION['csrf_token']; ?>');
                        
                        fetch('', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                location.reload();
                            } else {
                                alert('Error: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error deleting programme');
                        });
                    }
                }
            });

            // Utility function to escape HTML
            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            // Close modal when clicking outside
            window.addEventListener('click', function(e) {
                if (e.target === addProgrammeModal) {
                    addProgrammeModal.style.display = 'none';
                }
            });
        });
    </script>
    
    <style>
        .modal {
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 5px;
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close:hover {
            color: black;
        }
        
        .programme-item {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .programme-actions button {
            margin-left: 10px;
        }
        
        .registrations-table {
            margin: 20px 0;
        }
        
        .registrations-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .registrations-table th,
        .registrations-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        .registrations-table th {
            background-color: #f2f2f2;
        }
        
        .registration-count {
            font-weight: bold;
            margin-top: 10px;
        }
        
        .admin-welcome {
            margin-right: 15px;
            color: #333;
        }
        
        .btn-primary, .btn-secondary, .btn-danger {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        
        .modal-actions {
            margin-top: 20px;
            text-align: right;
        }
        
        .modal-actions button {
            margin-left: 10px;
        }
    </style>
</body>
</html>