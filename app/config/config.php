<?php
    // database config
    // can be one of ("SQLITE", "MYSQL")
    define("DB", "SQLITE");

    // MySQL
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DB_NAME", "maher_album");
    
    // SQLite
    define("DB_PATH", "../db/db.db");


    // website stuff
    define("URLROOT", "http://localhost/album");
    define("APPROOT", dirname(dirname(__FILE__)));
    define("SITENAME", "Album");

    // assets
    define("COVERS_URL", "resources/covers");
    define("IMAGES_URL", "resources/images");

