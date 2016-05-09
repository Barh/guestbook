<?php

    // get page
    $page = Parameters::get();

    // incorrect
    if (Parameters::$incorrect) {
        Parameters::incorrect();
    }

    // page correct
    if ($page) {

        if ($page[0] == 'notes') { // notes
            if (!isset($page[1])) { // get list
                $type = 'notes'; $operation = 'get_list';
            } elseif ($page[1] == 'insert') { // insert
                $type = 'notes'; $operation = 'insert';
            } elseif (is_numeric($page[1]) && isset($page[2]) && $page[2] == 'comments') { // comments
                if (!isset($page[3])) { // get list
                    $type = 'comments'; $operation = 'get_list';
                } elseif ($page[3] == 'insert') { // insert
                    $type = 'comments'; $operation = 'insert';
                }
            }
        }

        // controller
        if (isset($type)) {
            include_once $type.'/'.$operation.'.php';
            include_once $operation.'.php';
        }

        // correct
        if ( isset($response) ) {
            // print json string
            ob_get_clean();
            echo json_encode($response);
            exit;
        } else { // incorrect
            Parameters::incorrect();
        }
    }