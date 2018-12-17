<?php

// Always provide a TRAILING SLASH (/) AFTER A PATH
define('URL', 'http://localhost/nbe/');
define('LIBS', 'libs/');

define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'nbe');
define('DB_USER', 'root');
define('DB_PASS', 'root');

// The sitewide hashkey, do not change this because its used for passwords!
// This is for other hash keys... Not sure yet
define('HASH_GENERAL_KEY', 'MixitUp200');

// This is for database passwords only
define('HASH_PASSWORD_KEY', 'p@ssw0rd#ismd');