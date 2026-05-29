

document.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);
    const programmeId = params.get("id");

    const programmeData = {
        "1": {
            name: "BSc Computer Science",
            description: "A comprehensive degree covering software development, artificial intelligence, cybersecurity, and database management. In Year 1, students learn the fundamentals of programming, mathematics for computing, computer architecture, and database design. Year 2 focuses on data structures, algorithms, software engineering practices, and the principles of AI. In Year 3, students explore networking, embedded systems, blockchain technologies, and complete a final-year project that applies their knowledge to real-world problems.",
            leader: "Dr. Alice Johnson",
            image: "https://onlinecourseing.com/wp-content/uploads/2021/11/15-Best-Computer-Science-Courses-Online-for-Beginners.jpg",
            modules: {
                year1: ["Introduction to Programming", "Mathematics for Computer Science", "Computer Systems & Architecture", "Databases"],
                year2: ["Software Engineering", "Algorithms & Data Structures", "Cyber Security Fundamentals", "Artificial Intelligence"],
                year3: ["Computer Networks", "Embedded Systems", "Blockchain Technologies", "Final Year Project"]
            }
        },
        "2": {
            name: "BSc Software Engineering",
            description: "This degree is designed for students interested in developing, testing, and maintaining software applications. Year 1 covers the basics of programming, computer systems, and databases. In Year 2, students focus on software design principles, mobile application development, and software testing. Year 3 introduces cloud computing, blockchain applications, and culminates in a final software development project, where students create a fully functional application using industry-standard tools and practices.",
            leader: "Dr. Brian Lee",
            image: "https://wallpaperaccess.com/full/3632441.jpg",
            modules: {
                year1: ["Introduction to Programming", "Mathematics for Computer Science", "Computer Systems & Architecture", "Databases"],
                year2: ["Software Engineering", "Algorithms & Data Structures", "Software Testing & Quality Assurance", "Human-Computer Interaction"],
                year3: ["Embedded Systems", "Blockchain Technologies", "Cloud Computing", "Final Year Project"]
            }
        },
        "3": {
            name: "BSc Artificial Intelligence",
            description: "A future-focused programme designed for students interested in machine learning, neural networks, and AI-driven applications. Year 1 introduces Python for AI, mathematical foundations, and computer architecture. In Year 2, students dive into machine learning, computer vision, and AI ethics, ensuring they understand both the technical and societal impact of AI. Year 3 advances into deep learning, neural network models, and a final AI research project, preparing students for careers in AI development and research.",
            leader: "Dr. Carol White",
            image: "https://www.udacity.com/blog/wp-content/uploads/2021/03/Advanced-AI-Courses_Blog.jpeg",
            modules: {
                year1: ["Introduction to AI", "Python for AI", "Mathematical Foundations"],
                year2: ["Machine Learning", "Computer Vision", "AI Ethics"],
                year3: ["Deep Learning", "Neural Networks", "AI Research Project"]
            }
        },
        "4": {
            name: "BSc Cyber Security",
            description: "This degree teaches students how to protect networks, systems, and data from cyber threats. Year 1 provides a foundation in cybersecurity principles, programming for security, and networking basics. In Year 2, students gain hands-on experience in ethical hacking, cryptography, and digital forensics. The final year focuses on penetration testing, cybersecurity law, and advanced cyber threat intelligence, along with a final project where students apply their skills to secure a real-world system.",
            leader: "Dr. David Green",
            image: "https://www.york.ac.uk/media/study/courses/postgraduate/computerscience/cyber%20security%20banner.jpg",
            modules: {
                year1: ["Introduction to Cyber Security", "Networking Basics", "Programming for Security"],
                year2: ["Ethical Hacking", "Cryptography", "Digital Forensics"],
                year3: ["Penetration Testing", "Cyber Security Law", "Security Research Project"]
            }
        },
        "5": {
            name: "BSc Data Science",
            description: "Focused on big data, machine learning, and statistical computing, this programme teaches students how to extract insights from large datasets. In Year 1, students learn data analysis, statistics, and programming for data science. Year 2 covers machine learning, big data processing, and predictive analytics. In Year 3, students advance into deep learning, cloud computing, and a capstone data science project, where they apply AI and statistical techniques to solve complex problems.",
            leader: "Dr. Emma Scott",
            image: "https://www.cdmi.in/courses@2x/data-science.webp",
            modules: {
                year1: ["Data Analysis", "Statistics", "Python for Data Science"],
                year2: ["Machine Learning", "Big Data Processing", "Predictive Analytics"],
                year3: ["Deep Learning", "Cloud Computing for Data", "Capstone Data Science Project"]
            }
        },
        "6": {
            name: "MSc Machine Learning",
            description: "A postgraduate degree specialising in deep learning, AI ethics, and neural networks. Year 1 focuses on advanced machine learning techniques, natural language processing, and deep learning. Year 2 covers AI applications in robotics, big data, and research methodologies. In Year 3, students undertake a final AI research project, exploring generative AI models, ethical considerations, and cutting-edge advancements in machine learning.",
            leader: "Dr. Sophia Miller",
            image: "https://theconstructor.org/wp-content/uploads/2021/05/ML1-scaled.jpg",
            modules: {
                year1: ["Advanced Machine Learning", "Deep Learning", "Natural Language Processing"],
                year2: ["AI and Robotics", "Big Data AI Applications", "Research Methods"],
                year3: ["Final AI Research Project", "Generative AI Models", "AI Ethics and Policy"]
            }
        },
        "7": {
            name: "MSc Cyber Security",
            description: "A specialised programme designed to train cybersecurity professionals in digital forensics, threat intelligence, and security policy. Year 1 covers advanced cryptography, penetration testing, and cloud security. Year 2 focuses on incident response, cybersecurity law, and risk management. In the final year, students complete a cybersecurity research project, applying AI-driven security measures and forensic analysis to detect and prevent cyber threats.",
            leader: "Dr. Benjamin Carter",
            image: "https://www.york.ac.uk/media/study/courses/postgraduate/computerscience/cyber%20security%20banner.jpg",
            modules: {
                year1: ["Advanced Cryptography", "Network Penetration Testing", "Cloud Security"],
                year2: ["Incident Response", "Cyber Law & Policy", "Security Risk Management"],
                year3: ["Security Research Project", "AI for Security", "Digital Forensics"]
            }
        }, 
        "8": {
            name: "MSc Data Science",
            description: "An advanced course on data analytics, AI, and cloud computing. Year 1 focuses on big data processing, statistical modelling, and ethics in data science. In Year 2, students study deep learning for data analytics, cloud-based data solutions, and real-time data processing. Year 3 culminates in a data science research project, exploring AI-powered insights, data security challenges, and predictive modelling techniques.",
            leader: "Dr. Chloe Thompson",
            image: "https://www.cdmi.in/courses@2x/data-science.webp",
            modules: {
                year1: ["Big Data Processing", "Statistical Modelling", "Data Science Ethics"],
                year2: ["Deep Learning for Data", "Cloud-Based Analytics", "Real-Time Data Processing"],
                year3: ["Advanced AI for Data Science", "Capstone Data Research Project", "Data Security"]
            }
        },
        "9": {
            name: "MSc Artificial Intelligence",
            description: "A research-driven programme that explores AI applications, deep learning frameworks, and ethical considerations. Year 1 covers AI research methods, cognitive AI, and deep learning models. Year 2 moves into autonomous systems, AI governance, and AI-driven robotics. The final year includes a capstone AI research project, where students apply AI technologies in areas like healthcare, finance, or smart automation.",
            leader: "Dr. Daniel Robinson",
            image: "https://www.udacity.com/blog/wp-content/uploads/2021/03/Advanced-AI-Courses_Blog.jpeg",
            modules: {
                year1: ["AI Research Methods", "Deep Learning Frameworks", "Cognitive AI"],
                year2: ["Autonomous Systems", "AI Governance", "AI for Robotics"],
                year3: ["Final AI Capstone Project", "AI in Healthcare", "Generative AI Models"]
            }
        },
        "10": {
            name: "MSc Software Engineering",
            description: "A postgraduate programme designed for those looking to master software project management, blockchain applications, and cloud-based development. Year 1 covers agile development, software architecture, and project management. Year 2 introduces cloud computing, full-stack development, and secure software engineering. Year 3 includes a final research project, focusing on DevOps, AI integration in software, and large-scale system automation.",
            leader: "Dr. William Scott",
            image: "https://wallpaperaccess.com/full/3632441.jpg",
            modules: {
                year1: ["Software Project Management", "Agile Development", "Software Architecture"],
                year2: ["Cloud-Based Applications", "Full-Stack Development", "Secure Software Engineering"],
                year3: ["AI in Software Engineering", "Final Research Project", "DevOps and Automation"]
            }
        }
    };

    if (programmeData[programmeId]) {
        const programme = programmeData[programmeId];

        document.getElementById("programme-name").textContent = programme.name;
        document.getElementById("programme-header").style.backgroundImage = `url(${programme.image})`;
        document.getElementById("programme-description").textContent = programme.description;
        document.getElementById("programme-leader").textContent = programme.leader;

        const modulesYear1 = document.getElementById("modules-year1");
        const modulesYear2 = document.getElementById("modules-year2");
        const modulesYear3 = document.getElementById("modules-year3");

        modulesYear1.innerHTML = "";
        modulesYear2.innerHTML = "";
        modulesYear3.innerHTML = "";

        programme.modules.year1.forEach(module => {
            const li = document.createElement("li");
            li.textContent = module;
            modulesYear1.appendChild(li);
        });

        programme.modules.year2.forEach(module => {
            const li = document.createElement("li");
            li.textContent = module;
            modulesYear2.appendChild(li);
        });

        programme.modules.year3.forEach(module => {
            const li = document.createElement("li");
            li.textContent = module;
            modulesYear3.appendChild(li);
        });

        let storedRegistrations = JSON.parse(localStorage.getItem("registeredProgrammes")) || {};

        if (!Array.isArray(storedRegistrations[programmeId])) {
            storedRegistrations[programmeId] = [];
        }

        const registerForm = document.getElementById("register-form");
        const withdrawButton = document.getElementById("withdraw-button");

        if (registerForm) {
            registerForm.addEventListener("submit", function (event) {
                event.preventDefault();

                const studentName = document.getElementById("student-name").value.trim();
                const studentEmail = document.getElementById("student-email").value.trim();
                const registerMessage = document.getElementById("register-message");

                if (!studentName || !studentEmail) {
                    registerMessage.textContent = "Please fill in all fields.";
                    registerMessage.style.color = "red";
                    return;
                }

                if (!storedRegistrations[programmeId]) {
                    storedRegistrations[programmeId] = [];
                }

                const alreadyRegistered = storedRegistrations[programmeId].some(
                    (entry) => entry.email === studentEmail
                );

                if (alreadyRegistered) {
                    registerMessage.textContent = "You have already registered interest for this programme.";
                    registerMessage.style.color = "red";
                    return;
                }

                storedRegistrations[programmeId].push({ name: studentName, email: studentEmail });
                localStorage.setItem("registeredProgrammes", JSON.stringify(storedRegistrations));

                registerMessage.textContent = `Thank you, ${studentName}! You have registered interest for ${programme.name}.`;
                registerMessage.style.color = "green";

                registerForm.reset();
            });
        } else {
            console.error("Error: Register form not found in the DOM.");
        }


        if (withdrawButton) {
            withdrawButton.addEventListener("click", function (event) {
                event.preventDefault();

                const studentEmail = document.getElementById("student-email").value.trim();
                const withdrawMessage = document.getElementById("withdraw-message");
                const registerMessage = document.getElementById("register-message");

             
                registerMessage.textContent = "";
                withdrawMessage.textContent = ""; 
        
                if (!studentEmail) {
                    withdrawMessage.textContent = "Please enter your email to withdraw.";
                    withdrawMessage.style.color = "red";
                    return;
                }
        
                if (!storedRegistrations[programmeId]) {
                    withdrawMessage.textContent = "No registrations found.";
                    withdrawMessage.style.color = "red";
                    return;
                }
        
                const index = storedRegistrations[programmeId].findIndex(entry => entry.email === studentEmail);
        
                if (index !== -1) {
                    storedRegistrations[programmeId].splice(index, 1);
                    localStorage.setItem("registeredProgrammes", JSON.stringify(storedRegistrations));
                    withdrawMessage.textContent = "You have successfully withdrawn your interest.";
                    withdrawMessage.style.color = "green";
                } else {
                    withdrawMessage.textContent = "No registration found for this email.";
                    withdrawMessage.style.color = "red";
                }
            });
        }
    } else {
        document.querySelector(".programme-content").innerHTML = "<h2>Programme Not Found</h2>";
    }
});