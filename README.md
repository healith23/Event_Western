# Event Western Platform

Event Western is an interactive web application designed to help users discover, register, and post events happening across the Western Province of Sri Lanka (Colombo, Gampaha, Kalutara).

## Features
- Dynamic Event Feed with Category & District filters
- User Authentication (Registration, Login, Session Management)
- User Dashboard for creating and publishing new events to the feed
- Database-driven Contact Form

## Project Structure
- `css/` - Contains all custom stylesheet files (`style.css`)
- `js/` - Contains all custom interactive JavaScript files (`script.js`)
- `images/` - Directory containing event and gallery pictures
- `includes/` - Backend configuration (`db.php`) and helper scripts (`functions.php`)
- `auth/` - Processing scripts for user registration, login, and logout
- `index.php` - The main landing page
- `events.php` - Database-driven dynamic event catalog
- `gallery.php` - Event photo gallery with search filters
- `community.php` - User testimonials and community features
- `contact.php` - Database-driven contact form
- `dashboard.php` - Authenticated user interface to publish events to the database

## Setup Instructions
1. Install a local server environment like XAMPP or WAMP.
2. Place the `Event_Western` folder inside the `htdocs` (XAMPP) or `www` (WAMP) directory.
3. Open phpMyAdmin and create a new database named `event_western`.
4. Import the provided `database.sql` file into the `event_western` database to automatically set up the `users`, `events`, `messages`, and `event_registrations` tables along with dummy data.
5. Open your browser and navigate to `http://localhost/Event_Western/`.
