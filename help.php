<?php
require_once 'bootstrap.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help & Documentation - Unifind</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .help-section {
            margin-bottom: 4rem;
        }
        .help-section h2 {
            margin-bottom: 1.5rem;
            color: var(--primary-color);
        }
        .help-image {
            width: 100%;
            max-width: 800px;
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            margin: 1.5rem 0;
            border: 1px solid var(--border-color);
        }
        .step-list {
            list-style: none;
            counter-reset: step;
        }
        .step-list li {
            position: relative;
            padding-left: 3.5rem;
            margin-bottom: 1.5rem;
        }
        .step-list li::before {
            counter-increment: step;
            content: counter(step);
            position: absolute;
            left: 0;
            top: 0;
            width: 2.5rem;
            height: 2.5rem;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
        }
    </style>
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
            <h1>Help & Documentation</h1>
            <p style="color: var(--text-muted);">Learn how to make the most of Unifind</p>
        </header>

        <main>
            <section class="help-section">
                <h2>1. Getting Started</h2>
                <div class="card">
                    <p>Unifind is designed to be intuitive. You can start by searching for a specific program or university directly from the home page.</p>
                    <img src="public/assets/help/Search.png" alt="Search Interface" class="help-image">
                </div>
            </section>

            <section class="help-section">
                <h2>2. Using the Search</h2>
                <div class="card">
                    <ul class="step-list">
                        <li><strong>Enter Keywords:</strong> Type in the name of a degree (e.g., "Computer Science") or a university (e.g., "UZ").</li>
                        <li><strong>Browse Results:</strong> Results are categorized into Universities and Programs.</li>
                        <li><strong>View Details:</strong> Click on a program to see requirements and duration in a popup.</li>
                    </ul>
                    <img src="public/assets/help/ProgrammeResult.png" alt="Search Results" class="help-image">
                </div>
            </section>

            <section class="help-section">
                <h2>3. Exploring Universities</h2>
                <div class="card">
                    <p>The Universities page gives you a bird's-eye view of all institutions. Each profile contains detailed contact info and a full list of programs.</p>
                    <img src="public/assets/help/UniversitiesList.png" alt="Universities List" class="help-image">
                </div>
            </section>

            <section class="help-section">
                <h2>4. Opportunities & Resources</h2>
                <div class="card">
                    <p>Don't miss out on scholarships and internships in the Opportunities section, or check Useful Resources for academic guides and links.</p>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <img src="public/assets/help/Opportunities.png" alt="Opportunities" class="help-image">
                        <img src="public/assets/help/UsefulResources.png" alt="Resources" class="help-image">
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
