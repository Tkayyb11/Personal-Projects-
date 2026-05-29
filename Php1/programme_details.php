<?php
session_start();

// Programme data array
$programmeData = [
    "bsc-computer-science" => [
        "name" => "BSc Computer Science",
        "description" => "A comprehensive degree covering software development, artificial intelligence, cybersecurity, and database management. In Year 1, students learn the fundamentals of programming, mathematics for computing, computer architecture, and database design. Year 2 focuses on data structures, algorithms, software engineering practices, and the principles of AI. In Year 3, students explore networking, embedded systems, blockchain technologies, and complete a final-year project that applies their knowledge to real-world problems.",
        "leader" => "Dr. Alice Johnson",
        "image" => "https://onlinecourseing.com/wp-content/uploads/2021/11/15-Best-Computer-Science-Courses-Online-for-Beginners.jpg",
        "modules" => [
            "year1" => ["Introduction to Programming", "Mathematics for Computer Science", "Computer Systems & Architecture", "Databases"],
            "year2" => ["Software Engineering", "Algorithms & Data Structures", "Cyber Security Fundamentals", "Artificial Intelligence"],
            "year3" => ["Computer Networks", "Embedded Systems", "Blockchain Technologies", "Final Year Project"]
        ]
    ],
    "bsc-software-engineering" => [
        "name" => "BSc Software Engineering",
        "description" => "This degree is designed for students interested in developing, testing, and maintaining software applications. Year 1 covers the basics of programming, computer systems, and databases. In Year 2, students focus on software design principles, mobile application development, and software testing. Year 3 introduces cloud computing, blockchain applications, and culminates in a final software development project, where students create a fully functional application using industry-standard tools and practices.",
        "leader" => "Dr. Brian Lee",
        "image" => "https://wallpaperaccess.com/full/3632441.jpg",
        "modules" => [
            "year1" => ["Introduction to Programming", "Mathematics for Computer Science", "Computer Systems & Architecture", "Databases"],
            "year2" => ["Software Engineering", "Algorithms & Data Structures", "Software Testing & Quality Assurance", "Human-Computer Interaction"],
            "year3" => ["Embedded Systems", "Blockchain Technologies", "Cloud Computing", "Final Year Project"]
        ]
    ],
    "bsc-artificial-intelligence" => [
        "name" => "BSc Artificial Intelligence",
        "description" => "A future-focused programme designed for students interested in machine learning, neural networks, and AI-driven applications. Year 1 introduces Python for AI, mathematical foundations, and computer architecture. In Year 2, students dive into machine learning, computer vision, and AI ethics, ensuring they understand both the technical and societal impact of AI. Year 3 advances into deep learning, neural network models, and a final AI research project, preparing students for careers in AI development and research.",
        "leader" => "Dr. Carol White",
        "image" => "https://www.udacity.com/blog/wp-content/uploads/2021/03/Advanced-AI-Courses_Blog.jpeg",
        "modules" => [
            "year1" => ["Introduction to AI", "Python for AI", "Mathematical Foundations"],
            "year2" => ["Machine Learning", "Computer Vision", "AI Ethics"],
            "year3" => ["Deep Learning", "Neural Networks", "AI Research Project"]
        ]
    ],
    "bsc-cyber-security" => [
        "name" => "BSc Cyber Security",
        "description" => "This degree teaches students how to protect networks, systems, and data from cyber threats. Year 1 provides a foundation in cybersecurity principles, programming for security, and networking basics. In Year 2, students gain hands-on experience in ethical hacking, cryptography, and digital forensics. The final year focuses on penetration testing, cybersecurity law, and advanced cyber threat intelligence, along with a final project where students apply their skills to secure a real-world system.",
        "leader" => "Dr. David Green",
        "image" => "https://www.york.ac.uk/media/study/courses/postgraduate/computerscience/cyber%20security%20banner.jpg",
        "modules" => [
            "year1" => ["Introduction to Cyber Security", "Networking Basics", "Programming for Security"],
            "year2" => ["Ethical Hacking", "Cryptography", "Digital Forensics"],
            "year3" => ["Penetration Testing", "Cyber Security Law", "Security Research Project"]
        ]
    ],
    "bsc-data-science" => [
        "name" => "BSc Data Science",
        "description" => "Focused on big data, machine learning, and statistical computing, this programme teaches students how to extract insights from large datasets. In Year 1, students learn data analysis, statistics, and programming for data science. Year 2 covers machine learning, big data processing, and predictive analytics. In Year 3, students advance into deep learning, cloud computing, and a capstone data science project, where they apply AI and statistical techniques to solve complex problems.",
        "leader" => "Dr. Emma Scott",
        "image" => "https://www.cdmi.in/courses@2x/data-science.webp",
        "modules" => [
            "year1" => ["Data Analysis", "Statistics", "Python for Data Science"],
            "year2" => ["Machine Learning", "Big Data Processing", "Predictive Analytics"],
            "year3" => ["Deep Learning", "Cloud Computing for Data", "Capstone Data Science Project"]
        ]
    ],
    "msc-machine-learning" => [
        "name" => "MSc Machine Learning",
        "description" => "A postgraduate degree specialising in deep learning, AI ethics, and neural networks. Year 1 focuses on advanced machine learning techniques, natural language processing, and deep learning. Year 2 covers AI applications in robotics, big data, and research methodologies. In Year 3, students undertake a final AI research project, exploring generative AI models, ethical considerations, and cutting-edge advancements in machine learning.",
        "leader" => "Dr. Sophia Miller",
        "image" => "https://theconstructor.org/wp-content/uploads/2021/05/ML1-scaled.jpg",
        "modules" => [
            "year1" => ["Advanced Machine Learning", "Deep Learning", "Natural Language Processing"],
            "year2" => ["AI and Robotics", "Big Data AI Applications", "Research Methods"],
            "year3" => ["Final AI Research Project", "Generative AI Models", "AI Ethics and Policy"]
        ]
    ],
    "msc-cyber-security" => [
        "name" => "MSc Cyber Security",
        "description" => "A specialised programme designed to train cybersecurity professionals in digital forensics, threat intelligence, and security policy. Year 1 covers advanced cryptography, penetration testing, and cloud security. Year 2 focuses on incident response, cybersecurity law, and risk management. In the final year, students complete a cybersecurity research project, applying AI-driven security measures and forensic analysis to detect and prevent cyber threats.",
        "leader" => "Dr. Benjamin Carter",
        "image" => "https://www.york.ac.uk/media/study/courses/postgraduate/computerscience/cyber%20security%20banner.jpg",
        "modules" => [
            "year1" => ["Advanced Cryptography", "Network Penetration Testing", "Cloud Security"],
            "year2" => ["Incident Response", "Cyber Law & Policy", "Security Risk Management"],
            "year3" => ["Security Research Project", "AI for Security", "Digital Forensics"]
        ]
    ],
    "msc-data-science" => [
        "name" => "MSc Data Science",
        "description" => "An advanced course on data analytics, AI, and cloud computing. Year 1 focuses on big data processing, statistical modelling, and ethics in data science. In Year 2, students study deep learning for data analytics, cloud-based data solutions, and real-time data processing. Year 3 culminates in a data science research project, exploring AI-powered insights, data security challenges, and predictive modelling techniques.",
        "leader" => "Dr. Chloe Thompson",
        "image" => "https://www.cdmi.in/courses@2x/data-science.webp",
        "modules" => [
            "year1" => ["Big Data Processing", "Statistical Modelling", "Data Science Ethics"],
            "year2" => ["Deep Learning for Data", "Cloud-Based Analytics", "Real-Time Data Processing"],
            "year3" => ["Advanced AI for Data Science", "Capstone Data Research Project", "Data Security"]
        ]
    ],
    "msc-artificial-intelligence" => [
        "name" => "MSc Artificial Intelligence",
        "description" => "A research-driven programme that explores AI applications, deep learning frameworks, and ethical considerations. Year 1 covers AI research methods, cognitive AI, and deep learning models. Year 2 moves into autonomous systems, AI governance, and AI-driven robotics. The final year includes a capstone AI research project, where students apply AI technologies in areas like healthcare, finance, or smart automation.",
        "leader" => "Dr. Daniel Robinson",
        "image" => "https://www.udacity.com/blog/wp-content/uploads/2021/03/Advanced-AI-Courses_Blog.jpeg",
        "modules" => [
            "year1" => ["AI Research Methods", "Deep Learning Frameworks", "Cognitive AI"],
            "year2" => ["Autonomous Systems", "AI Governance", "AI for Robotics"],
            "year3" => ["Final AI Capstone Project", "AI in Healthcare", "Generative AI Models"]
        ]
    ],
    "msc-software-engineering" => [
        "name" => "MSc Software Engineering",
        "description" => "A postgraduate programme designed for those looking to master software project management, blockchain applications, and cloud-based development. Year 1 covers agile development, software architecture, and project management. Year 2 introduces cloud computing, full-stack development, and secure software engineering. Year 3 includes a final research project, focusing on DevOps, AI integration in software, and large-scale system automation.",
        "leader" => "Dr. William Scott",
        "image" => "https://wallpaperaccess.com/full/3632441.jpg",
        "modules" => [
            "year1" => ["Software Project Management", "Agile Development", "Software Architecture"],
            "year2" => ["Cloud-Based Applications", "Full-Stack Development", "Secure Software Engineering"],
            "year3" => ["AI in Software Engineering", "Final Research Project", "DevOps and Automation"]
        ]
    ]
];

// Fetch and validate the programme ID from the URL
$id = $_GET['id'] ?? '';
if (!isset($programmeData[$id])) {
    echo "<h1>Programme not found</h1>";
    echo "<p>Available programmes:</p>";
    echo "<ul>";
    foreach ($programmeData as $progId => $prog) {
        echo "<li><a href='?id=" . $progId . "'>" . $prog['name'] . "</a></li>";
    }
    echo "</ul>";
    exit; // Add exit to stop execution if programme not found
    
}
$programme = $programmeData[$id];
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title><?php echo htmlspecialchars($programme['name']); ?></title>
    
</head>
<body>
    <h1><?php echo htmlspecialchars($programme['name']); ?></h1>
    <img src="<?php echo htmlspecialchars($programme['image']); ?>" alt="<?php echo htmlspecialchars($programme['name']); ?>">
    <h3>Programme Leader: <?php echo htmlspecialchars($programme['leader']); ?></h3>
    <p><?php echo htmlspecialchars($programme['description']); ?></p>

    <h2>Modules by Year</h2>
    <?php foreach ($programme['modules'] as $year => $modules): ?>
        <h3><?php echo htmlspecialchars(ucfirst($year)); ?></h3>
        <ul>
            <?php foreach ($modules as $module): ?>
                <li><?php echo htmlspecialchars($module); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>
</body>
</html>