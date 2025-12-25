<?php
// No backend logic needed currently, simple static page with contact form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>About Us - Unifind</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
            background-color: #f8f8f8;
            color: #222;
            line-height: 1.6;
        }
        h1 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #000;
            text-align: center;
        }
        h2 {
            margin-top: 2rem;
            color: #000;
        }
        p {
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }
        form {
            margin-top: 1rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        label {
            font-weight: 600;
        }
        input, textarea {
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
            font-size: 1rem;
            resize: vertical;
        }
        button {
            background: #000;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            max-width: 150px;
        }
        .donate-section {
            margin-top: 2rem;
            padding: 1rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .donate-section h3 {
            margin-top: 0;
        }
        nav a {
            color: #000;
            text-decoration: none;
            margin-right: 1rem;
            font-weight: 600;
        }
        nav a:hover {
            text-decoration: underline;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="index.html">Search</a>
        <a href="UniList.php">Universities</a>
        <a href="ProgramOptions.php">Program Options</a>
        <a href="UsefulResources.php">Useful resources</a>
        <a href="Opportunities.php">Opportunities</a>
        <a href="Us.php">About Us</a>
        <a href="help.php">Help</a>
    </div>

    <span class="menu-btn" onclick="openNav()">&#9776;</span>

    <h1>About Me</h1>

    <section>
        <h2>My Story</h2>
        <p>I am an independent developer who created Unifind as a passion project to help students find universities and programs easily.</p>
        <p>More about the story and mission will be added soon.</p>
    </section>

    <section>
        <h2>Contact Us</h2>
        <form method="post" action="contact_submit.php">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required />

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required />

            <label for="message">Message</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit">Send</button>
        </form>
    </section>

    <section class="donate-section">
        <h2>Donate to Us</h2>
        <p>Running this service is expensive and requires ongoing support. If you find Unifind useful, please consider donating.</p>
        <p>Multiple contact methods and donation options will be added soon.</p>
    </section>

    <script src="script.js"></script>
</body>
</html>
