<?php

    // Errors
    ini_set('display_errors', 'on');
    error_reporting(E_ALL); // Записывать(показывать) все ошибки

    // AutoLoader
    chdir('../engine');
    include_once 'settings.php';
    include_once 'includes/AutoLoader.php';

    // prepare tables
    if (!Tables::is()) {
        Tables::create();
    }

    // Pages
    include_once 'controllers/pages.php';

    // Main template
    include_once 'templates/main.php';
