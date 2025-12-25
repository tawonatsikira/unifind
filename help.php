<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Help - Unifind</title>
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
        img {
            max-width: 100%;
            border-radius: 8px;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .note {
            margin-top: 3rem;
            font-style: italic;
            color: #555;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 1rem;
        }
        a {
            color: inherit;
            text-decoration: none;
        }
        a:hover {
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


    <h1>Help Guide for Unifind</h1>

    <h2>Welcome to Unifind!</h2>
    <p>A simple but hopefully useful guide on what each page on this site does </p>

    <h2>Page Navigation</h2>
    <p>Before we begin I think it's a good idea I tell you how to get around the page first</p>
    <img src="extras/help/NavMenu.png" alt="Side Navigation Button" />
    <p>Clicking or tapping on those three lines open the side navigation which shows you a menu to navigate to whatever page you want</p>
    <img src="extras/help/NavMenuOpen.png" alt="Side Navigation " />



    <h2>1. Search Page</h2>
    <p>The Search page is the first page you see. You can type the name of a university or a program you want to find in the search box.</p>
    <img src="extras/help/Search.png" alt="Search Page Screenshot" />
    <p>After typing your query, click the "Search" button. You will see a list of matching universities and programs.</p>

    <h3>Understanding Search Results</h3>
    <p>The search results show both universities and programs that match your query. Each result includes:</p>
    <ul>
        <li><strong>Title:</strong> The name of the university or program.</li>
        <li><strong>Description:</strong> A brief overview of the university or program.</li>
        <li><strong>Type:</strong> Indicates if the result is a university or a program.</li>
        <li><strong>Additional Info:</strong> For programs, you will see the faculty and the university offering it, along with fields of study.</li>
    </ul>
    <img src="extras/help/UniversityResult.png" alt="Search Results - University" />
    <img src="extras/help/ProgrammeResult.png" alt="Search Results - Program" />
    <p>Click on a university name to view detailed information about that university.</p>
    <p>Click on a program name to see more details in a popup modal.</p>
    <img src="extras/help/ProgrammeResultClicked.png" alt="Click Program Result" />

    <h2>2. Universities List</h2>
    <p>Click on "Universities" in the menu to see a list of all universities.</p>
    <img src="extras/help/UniversitiesList.png" alt="Universities List Screenshot" />
    <p>Click on any university name to see more details about it.</p>

    <h2>3. University Details</h2>
    <p>On the University Details page, you can see information about the university, programs it offers, and latest announcements.</p>
    <img src="extras/help/university_details.png" alt="University Details Screenshot" />
    <p>Use the tabs to switch between general info, programs, and announcements.</p>

    <h2>4. Program Options</h2>
    <p>On the Program Options page, you can select subjects you have studied to find programs that match your subjects.</p>
    <img src="extras/help/ProgramOptions.png" alt="Program Options Screenshot" />
    <p>Select up to 4 subjects and click "Find Matching Programs" to see programs you qualify for.</p>

    <h2>5. Useful Resources</h2>
    <p>The Useful Resources page has helpful links and articles to guide you in your university journey and career planning.</p>
    <img src="extras/help/UsefulResources.png" alt="Useful Resources Screenshot" />

    <h2>6. Opportunities</h2>
    <p>The Opportunities page lists scholarships, internships, apprenticeships, and other chances to help you grow.</p>
    <img src="extras/help/Opportunities.png" alt="Opportunities Screenshot" />

    <h2>7. Help Page</h2>
    <p>I don't have a clue what this one does either.</p>


    <div class="note">
        <p>This was a passion project I just made because I thought it could be really useful.</p>
        <p><strong>Note:</strong> This site is still in development and currently incomplete. I am working on many features, but I would really appreciate it if you could share this site and leave some feedback. Thank you!</p>
    </div>

    <script src="script.js"></script>
</body>
</html>
