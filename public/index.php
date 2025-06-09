<?php
// This is the entry point for the application.
// Initialize the application and route requests to the appropriate controllers.

// Autoload classes using Composer
require_once '../vendor/autoload.php';

// Start the session
session_start();

// Define the base URL
define('BASE_URL', '/cultural-events-app/public/');

// Include the router or front controller
require_once '../src/router.php';
?>