<?php
// ERRO REPORTING
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

// Generally this config holds all the functions, database connections and configurations. 
// Revised it based on your needs.
// Code legibly and clean as possible.

// INSERT ROUTES
// here includes all the routes you need to insert. every page you made. and call the file itself.
include_once('routes.php');

// DATABASE CONNECTION
include_once('database.php');

// BASIC FUNCTIONS
include_once('functions.php');
?>