<?php

# Database connection
define("DB_SERVER", "localhost");
define("DB_USER_USERNAME", "root");
define("DB_USER_PASSWORD", "root");
define("DB_NAME", "event");

# Default Admin Name
define("DEFAULT_ADMIN_USERNAME", "admin");
define("DEFAULT_ADMIN_EMAIL", "admin@gmail.com");
define("DEFAULT_ADMIN_PASSWORD", "admin");

# Define default path

define("__BASEURL__", "/PraSerkom");
define("__BASEPATH__", dirname(__DIR__, 2));

session_start();
