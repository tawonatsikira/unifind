# Unifind - University and Program Search System

## Overview

Unifind is a comprehensive web application designed to help students search and discover universities and academic programs in Zimbabwe. The system provides a user-friendly interface for exploring university information, program details, announcements, and educational resources.

## Features

- **Advanced Search**: Intelligent search algorithm for universities and programs with similarity scoring.
- **University Profiles**: Detailed university information including contact details, addresses, and descriptions.
- **Program Catalog**: Comprehensive program listings with specializations, durations, and admission requirements.
- **Announcements System**: Real-time university-specific announcements and updates.
- **Resource Directory**: Curated educational resources and opportunities (scholarships, internships).
- **Responsive Design**: Modern, mobile-friendly interface with smooth transitions and interactive modals.

## Quick Start

### Requirements
- **PHP 8.1+** (Command Line Interface or Web Server)
- **Web Server** (Apache, Nginx, or PHP built-in server)
- **Modern Browser** (Chrome, Firefox, Safari, Edge)

### Installation
1.  Clone or extract the project files to your web server directory.
2.  Ensure PHP is installed on your system.
3.  The system uses file-based JSON storage, so no database setup is required.

### Running Locally
You can use the PHP built-in server for quick testing:
```bash
php -S localhost:8000
```
Then visit `http://localhost:8000` in your browser.

## Usage

### Searching
1.  Enter a university name, program name, or field of study in the search bar.
2.  The system will return matches sorted by relevance.
3.  Click on a university to view its full profile or a program to see details in a popup.

### University View
- **General Information**: Overview and contact details.
- **Programmes**: List of all programs offered, grouped by faculty.
- **Announcements**: Latest updates from the university.

## License
This project is for educational purposes. All rights reserved.

