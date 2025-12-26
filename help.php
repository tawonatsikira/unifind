<?php
require_once 'bootstrap.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Help & Documentation - Unifind</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .step-card {
            display: flex;
            gap: 2rem;
            align-items: center;
            margin-bottom: 4rem;
        }
        .step-number {
            width: 60px;
            height: 60px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 800;
            flex-shrink: 0;
            box-shadow: var(--shadow-md);
        }
        .help-img {
            width: 100%;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
            margin-top: 1.5rem;
        }
        @media (max-width: 768px) {
            .step-card { flex-direction: column; align-items: flex-start; gap: 1rem; }
        }
    </style>
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
        <header style="margin-bottom: 5rem; text-align: center;">
            <span class="badge-modern badge-primary mb-4">Support Center</span>
            <h1>How to use Unifind</h1>
            <p style="color: var(--text-muted); max-width: 600px; margin: 1rem auto 0;">Master the platform and find your academic path in minutes.</p>
        </header>

        <main style="max-width: 900px; margin: 0 auto;">
            <div class="step-card">
                <div class="step-number">1</div>
                <div style="flex: 1;">
                    <h3>Start Your Search</h3>
                    <p style="color: var(--text-muted); margin-top: 0.5rem;">Use the main search bar to find programs, universities, or specific fields of study.</p>
                    <img src="public/assets/help/Search.png" alt="Search Interface" class="help-img">
                </div>
            </div>

            <div class="step-card">
                <div class="step-number">2</div>
                <div style="flex: 1;">
                    <h3>Explore Results</h3>
                    <p style="color: var(--text-muted); margin-top: 0.5rem;">Browse through categorized results. Each card gives you a quick overview of the match.</p>
                    <img src="public/assets/help/ProgrammeResult.png" alt="Search Results" class="help-img">
                </div>
            </div>

            <div class="step-card">
                <div class="step-number">3</div>
                <div style="flex: 1;">
                    <h3>View University Profiles</h3>
                    <p style="color: var(--text-muted); margin-top: 0.5rem;">Click on a university to see its full profile, including all offered programs and latest announcements.</p>
                    <img src="public/assets/help/UniversitiesList.png" alt="Universities List" class="help-img">
                </div>
            </div>

            <div class="step-card">
                <div class="step-number">4</div>
                <div style="flex: 1;">
                    <h3>Check Requirements</h3>
                    <p style="color: var(--text-muted); margin-top: 0.5rem;">Click on any program to see a detailed breakdown of requirements, duration, and faculty information.</p>
                    <img src="public/assets/help/ProgramOptions.png" alt="Program Details" class="help-img">
                </div>
            </div>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
