<?php


// Check if user is logged in
session_start();
$isLoggedIn = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Course Hub - Modules</title>
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
            <h2>Filter Modules</h2>
            <label>
                <input type="checkbox" id="undergraduate" value="undergraduate" checked> Undergraduate
            </label>
            <label>
                <input type="checkbox" id="postgraduate" value="postgraduate" checked> Postgraduate
            </label>
            <section class="search-container">
                <input type="text" id="search-bar" placeholder="Search for a module...">
            </section>
        </section>

        <section class="programmes">
            <h2>Our Modules</h2>
            <div class="module-list" id="module-container">
                <?php
                // Array of modules - in a real application, this would come from a database
                $modules = [
                    [
                        'title' => 'Introduction to Programming',
                        'level' => 'undergraduate',
                        'leader' => 'Dr. Alice Johnson',
                        'description' => 'Covers the fundamentals of programming using Python and Java.',
                        'courses' => 'All Undergraduate Computer Science Programmes'
                    ],
                    [
                        'title' => 'Mathematics for Computer Science',
                        'level' => 'undergraduate',
                        'leader' => 'Dr. Brian Lee',
                        'description' => 'Teaches discrete mathematics, linear algebra, and probability theory.',
                        'courses' => 'All Undergraduate Computer Science Programmes'
                    ],
                    [
                        'title' => 'Computer Systems & Architecture',
                        'level' => 'undergraduate',
                        'leader' => 'Dr. Carol White',
                        'description' => 'Explores CPU design, memory management, and assembly language.',
                        'courses' => 'BSc Computer Science, BSc Software Engineering'
                    ],
                    [
                        'title' => 'Databases',
                        'level' => 'undergraduate',
                        'leader' => 'Dr. David Green',
                        'description' => 'Covers SQL, relational database design, and NoSQL systems.',
                        'courses' => 'BSc Computer Science, BSc Data Science'
                    ],
                    [
                        'title' => 'Software Engineering',
                        'level' => 'undergraduate',
                        'leader' => 'Dr. Emma Scott',
                        'description' => 'Focuses on agile development, design patterns, and project management.',
                        'courses' => 'BSc Software Engineering, BSc Computer Science'
                    ],
                    [
                        'title' => 'Algorithms & Data Structures',
                        'level' => 'undergraduate',
                        'leader' => 'Dr. Frank Moore',
                        'description' => 'Examines sorting, searching, graphs, and complexity analysis.',
                        'courses' => 'BSc Computer Science, BSc Data Science'
                    ],
                    [
                        'title' => 'Cyber Security Fundamentals',
                        'level' => 'undergraduate',
                        'leader' => 'Dr. Grace Adams',
                        'description' => 'Provides an introduction to network security, cryptography, and vulnerabilities.',
                        'courses' => 'BSc Cyber Security'
                    ],
                    [
                        'title' => 'Artificial Intelligence',
                        'level' => 'undergraduate',
                        'leader' => 'Dr. Henry Clark',
                        'description' => 'Introduces AI concepts such as neural networks, expert systems, and robotics.',
                        'courses' => 'BSc Artificial Intelligence, BSc Computer Science'
                    ],
                    [
                        'title' => 'Machine Learning',
                        'level' => 'undergraduate',
                        'leader' => 'Dr. Irene Hall',
                        'description' => 'Explores supervised and unsupervised learning, including decision trees and clustering.',
                        'courses' => 'BSc Data Science, BSc Artificial Intelligence'
                    ],
                    [
                        'title' => 'Ethical Hacking',
                        'level' => 'undergraduate',
                        'leader' => 'Dr. James Wright',
                        'description' => 'Covers penetration testing, security assessments, and cybersecurity laws.',
                        'courses' => 'BSc Cyber Security'
                    ],
                    [
                        'title' => 'Computer Networks',
                        'level' => 'undergraduate',
                        'leader' => 'Dr. Alice Johnson',
                        'description' => 'Teaches TCP/IP, network layers, and wireless communication.',
                        'courses' => 'BSc Computer Science, BSc Cyber Security'
                    ],
                    [
                        'title' => 'Software Testing & Quality Assurance',
                        'level' => 'undergraduate',
                        'leader' => 'Dr. Brian Lee',
                        'description' => 'Focuses on automated testing, debugging, and code reliability.',
                        'courses' => 'BSc Software Engineering, BSc Computer Science'
                    ],
                    [
                        'title' => 'Embedded Systems',
                        'level' => 'undergraduate',
                        'leader' => 'Dr. Carol White',
                        'description' => 'Examines microcontrollers, real-time OS, and IoT applications.',
                        'courses' => 'BSc Computer Science, BSc Software Engineering'
                    ],
                    [
                        'title' => 'Human-Computer Interaction',
                        'level' => 'undergraduate',
                        'leader' => 'Dr. David Green',
                        'description' => 'Studies UI/UX design, usability testing, and accessibility.',
                        'courses' => 'BSc Software Engineering, BSc Computer Science, BSc Data Science'
                    ],
                    [
                        'title' => 'Blockchain Technologies',
                        'level' => 'undergraduate',
                        'leader' => 'Dr. Emma Scott',
                        'description' => 'Covers distributed ledgers, consensus mechanisms, and smart contracts.',
                        'courses' => 'BSc Software Engineering, MSc Software Engineering'
                    ],
                    [
                        'title' => 'Cloud Computing',
                        'level' => 'undergraduate',
                        'leader' => 'Dr. Frank Moore',
                        'description' => 'Introduces cloud services, virtualization, and distributed systems.',
                        'courses' => 'BSc Data Science, BSc Computer Science, MSc Data Science'
                    ],
                    [
                        'title' => 'Digital Forensics',
                        'level' => 'undergraduate',
                        'leader' => 'Dr. Grace Adams',
                        'description' => 'Teaches forensic investigation techniques for cybercrime.',
                        'courses' => 'BSc Cyber Security, MSc Cyber Security'
                    ],
                    [
                        'title' => 'Final Year Project',
                        'level' => 'undergraduate',
                        'leader' => 'Dr. Henry Clark',
                        'description' => 'A major independent project where students develop a software solution.',
                        'courses' => 'All Undergraduate Computer Science Programmes'
                    ],
                    [
                        'title' => 'Advanced Machine Learning',
                        'level' => 'postgraduate',
                        'leader' => 'Dr. Sophia Miller',
                        'description' => 'Covers deep learning, reinforcement learning, and cutting-edge AI techniques.',
                        'courses' => 'MSc Machine Learning, MSc Artificial Intelligence'
                    ],
                    [
                        'title' => 'Cyber Threat Intelligence',
                        'level' => 'postgraduate',
                        'leader' => 'Dr. Benjamin Carter',
                        'description' => 'Focuses on cybersecurity risk analysis, malware detection, and threat mitigation.',
                        'courses' => 'MSc Cyber Security'
                    ],
                    [
                        'title' => 'Big Data Analytics',
                        'level' => 'postgraduate',
                        'leader' => 'Dr. Chloe Thompson',
                        'description' => 'Explores data mining, distributed computing, and AI-driven insights.',
                        'courses' => 'MSc Data Science'
                    ],
                    [
                        'title' => 'Cloud & Edge Computing',
                        'level' => 'postgraduate',
                        'leader' => 'Dr. Daniel Robinson',
                        'description' => 'Examines scalable cloud platforms, serverless computing, and edge networks.',
                        'courses' => 'MSc Data Science, MSc Software Engineering'
                    ],
                    [
                        'title' => 'Blockchain & Cryptography',
                        'level' => 'postgraduate',
                        'leader' => 'Dr. Emily Davis',
                        'description' => 'Covers decentralized applications, consensus algorithms, and security measures.',
                        'courses' => 'MSc Cyber Security, MSc Software Engineering'
                    ],
                    [
                        'title' => 'AI Ethics & Society',
                        'level' => 'postgraduate',
                        'leader' => 'Dr. Nathan Hughes',
                        'description' => 'Analyzes ethical dilemmas in AI, fairness, bias, and regulatory considerations.',
                        'courses' => 'MSc Machine Learning, MSc Artificial Intelligence'
                    ],
                    [
                        'title' => 'Quantum Computing',
                        'level' => 'postgraduate',
                        'leader' => 'Dr. Olivia Martin',
                        'description' => 'Introduces quantum algorithms, qubits, and cryptographic applications.',
                        'courses' => 'MSc Software Engineering'
                    ],
                    [
                        'title' => 'Cybersecurity Law & Policy',
                        'level' => 'postgraduate',
                        'leader' => 'Dr. Samuel Anderson',
                        'description' => 'Explores digital privacy, GDPR, and international cyber law.',
                        'courses' => 'MSc Cyber Security'
                    ],
                    [
                        'title' => 'Neural Networks & Deep Learning',
                        'level' => 'postgraduate',
                        'leader' => 'Dr. Victoria Hall',
                        'description' => 'Delves into convolutional networks, GANs, and AI advancements.',
                        'courses' => 'MSc Machine Learning, MSc Artificial Intelligence'
                    ],
                    [
                        'title' => 'Human-AI Interaction',
                        'level' => 'postgraduate',
                        'leader' => 'Dr. William Scott',
                        'description' => 'Studies AI usability, NLP systems, and social robotics.',
                        'courses' => 'MSc Artificial Intelligence'
                    ],
                    [
                        'title' => 'Autonomous Systems',
                        'level' => 'postgraduate',
                        'leader' => 'Dr. Sophia Miller',
                        'description' => 'Focuses on self-driving technology, robotics, and intelligent agents.',
                        'courses' => 'MSc Machine Learning, MSc Artificial Intelligence'
                    ],
                    [
                        'title' => 'Digital Forensics & Incident Response',
                        'level' => 'postgraduate',
                        'leader' => 'Dr. Benjamin Carter',
                        'description' => 'Teaches forensic analysis, evidence gathering, and threat mitigation.',
                        'courses' => 'MSc Cyber Security'
                    ],
                    [
                        'title' => 'Postgraduate Dissertation',
                        'level' => 'postgraduate',
                        'leader' => 'Dr. Chloe Thompson',
                        'description' => 'A major research project where students explore advanced topics in computing.',
                        'courses' => 'All Postgraduate Computing Programmes'
                    ]
                ];

                // Loop through modules and display them
                foreach ($modules as $module):
                ?>
                    <div class="module" data-level="<?php echo htmlspecialchars($module['level']); ?>">
                        <h3><?php echo htmlspecialchars($module['title']); ?></h3>
                        <div class="module-leader">Module Leader: <?php echo htmlspecialchars($module['leader']); ?></div>
                        <p class="module-description"><?php echo htmlspecialchars($module['description']); ?></p>
                        <div class="module-courses">Relevant Courses: <?php echo htmlspecialchars($module['courses']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const checkboxes = document.querySelectorAll('.filter input[type="checkbox"]');
            const modules = document.querySelectorAll('.module');
            const searchBar = document.getElementById("search-bar");

            function updateModuleVisibility() {
                const selectedLevels = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);
                const searchTerm = searchBar.value.toLowerCase().trim();

                modules.forEach(module => {
                    const moduleName = module.querySelector("h3").textContent.toLowerCase();
                    const moduleDescription = module.querySelector(".module-description").textContent.toLowerCase();
                    const moduleLevel = module.getAttribute('data-level') || 'undergraduate';
                    
                    const matchesLevel = selectedLevels.includes(moduleLevel);
                    const matchesSearch = moduleName.includes(searchTerm) || moduleDescription.includes(searchTerm);
                    
                    module.style.display = (matchesLevel && matchesSearch) ? "block" : "none";
                });
            }

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", updateModuleVisibility);
            });

            searchBar.addEventListener("input", updateModuleVisibility);

            updateModuleVisibility();
        });
    </script>
</body>
</html>