<?php

    // Errors
    ini_set('display_errors', 'on');
    error_reporting(E_ALL); // Записывать(показывать) все ошибки

    // AutoLoader
    chdir('../engine');
    include_once 'settings.php';
    include_once 'includes/AutoLoader.php';

    // Prepare tables
    if (!Tables::is()) {
        Tables::create();
    }

    // Action
    if (isset($action)) {
        // drop tables
        if ($action == 'drop_tables') {
            Tables::drop();
            echo 'Dropped tables';
        }

        // fill tables
        if ($action == 'fill_tables') {
            Tables::fill();
            echo 'Filled tables';
        }

        exit;
    }

    // Data
    include_once 'controllers/data.php';

    // Main template
    include_once 'templates/main.php';
