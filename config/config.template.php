<?php
/**
 * To make your own config, duplicate this file and rename it "config.php",
 * fill out  the information below, and then open setup.php in a browser
 * (using xampp, or wamp....or whatever)
 */

define(BASE, preg_replace('/\/[^\/]+$/', '', dirname(__FILE__))."/");

$host     = 'localhost'; //localhost is the default.
$dbname   = ''; //The name of the database to use for the toon project.
$user     = ''; //The name of the user with privleges to this database. (default is usually 'root')
$password = ''; //The password for that user. (default is '')

require_once(BASE."config/defaultConfig.php");
