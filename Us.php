<?php
require_once 'bootstrap.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Unifind</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="index.html">Search</a>
        <a href="UniList.php">Universities</a>
        <a href="ProgramOptions.php">Program Options</a>
        <a href="UsefulResources.php">Useful Resources</a>
        <a href="Opportunities.php">Opportunities</a>
        <a href="Us.php">About Us</a>
        <a href="help.php">Help</a>
    </div>

    <button class="menu-btn" onclick="openNav()" aria-label="Open Menu">&#9776;</button>

    <div class="container">
        <header style="margin-bottom: 4rem; text-align: center;">
            <h1>About Unifind</h1>
            <p style="color: var(--text-muted);">Our mission and the team behind the platform</p>
        </header>

        <main>
            <section class="card" style="line-height: 1.8;">
                <h2>Our Mission</h2>
                <p style="font-size: 1.1rem; margin-top: 1rem;">
                    Unifind was created with a single goal in mind: <strong>to empower Zimbabwean students</strong> by providing them with the information they need to make informed decisions about their higher education.
                </p>
                <p style="margin-top: 1rem;">
                    We believe that every student deserves access to a clear, comprehensive, and easy-to-use directory of academic opportunities. By centralizing data from universities across the country, we bridge the gap between ambition and information.
                </p>
            </section>

            <section style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 3rem;">
                <div class="card">
                    <h3>What We Offer</h3>
                    <ul style="margin-top: 1rem; padding-left: 1.2rem;">
                        <li>Fuzzy search for programs and universities.</li>
                        <li>Detailed admission requirements.</li>
                        <li>Up-to-date university announcements.</li>
                        <li>Scholarship and internship listings.</li>
                    </ul>
                </div>
                <div class="card">
                    <h3>The Vision</h3>
                    <p style="margin-top: 1rem;">
                        We envision a future where every student in Zimbabwe can navigate their academic journey with confidence, backed by a platform that evolves with the changing educational landscape.
                    </p>
                </div>
            </section>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
