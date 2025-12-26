<?php
require_once 'bootstrap.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>About Us - Unifind</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="nav-header">
        <a href="index.html" class="logo-text">Unifind</a>
        <button class="menu-trigger" onclick="openNav()" aria-label="Open Menu">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>
    </nav>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="index.html">Home</a>
        <a href="UniList.php">Universities</a>
        <a href="ProgramOptions.php">Programs</a>
        <a href="Opportunities.php">Opportunities</a>
        <a href="UsefulResources.php">Resources</a>
        <a href="Us.php">About</a>
        <a href="help.php">Help</a>
    </div>

    <div class="container" style="padding-top: 100px;">
        <header style="margin-bottom: 4rem; text-align: center;">
            <span class="badge-modern badge-primary mb-4">Our Mission</span>
            <h1>About Unifind</h1>
            <p style="color: var(--text-muted); max-width: 600px; margin: 1rem auto 0;">The team and the vision behind Zimbabwe's leading academic directory.</p>
        </header>

        <main style="max-width: 800px; margin: 0 auto;">
            <section class="card mb-4" style="padding: 3rem; line-height: 1.8;">
                <h2 class="mb-4">Empowering the Next Generation</h2>
                <p style="font-size: 1.2rem; color: var(--text-header); font-weight: 500; margin-bottom: 1.5rem;">
                    Unifind was born from a simple observation: finding accurate information about higher education in Zimbabwe shouldn't be a challenge.
                </p>
                <p>
                    Our platform centralizes data from universities across the country, providing students with a clear, comprehensive, and easy-to-use directory. We believe that access to information is the first step toward academic success.
                </p>
                <p style="margin-top: 1.5rem;">
                    Whether you're a high school student planning your future or a professional looking to further your studies, Unifind is here to guide you.
                </p>
            </section>

            <div class="program-grid-modern">
                <div class="card">
                    <h3 class="mb-4">What We Offer</h3>
                    <ul style="padding-left: 1.2rem; display: flex; flex-direction: column; gap: 0.75rem;">
                        <li>Intelligent program search</li>
                        <li>Detailed admission requirements</li>
                        <li>University announcements</li>
                        <li>Scholarship listings</li>
                    </ul>
                </div>
                <div class="card">
                    <h3>Our Vision</h3>
                    <p style="margin-top: 1rem; color: var(--text-muted);">
                        To become the definitive resource for academic planning in Zimbabwe, evolving alongside the educational landscape to serve every student's needs.
                    </p>
                </div>
            </div>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
