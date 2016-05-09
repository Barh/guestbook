<?php

    // correct data
    if ($data = Parameters::filter($_POST, $req_data, true)) {

        // check data
        foreach ($req_data as $v) {
            if (empty($data[$v])) {
                $incorrect = true;
                break;
            }
        }

        // no empty
        if (!isset($incorrect)) {
            // add data
            if (isset($add_data)) {
                foreach ($add_data as $k=>$v) {
                    $data[$k] = $v;
                }
            }

            // Init object
            $record = new $class_name();

            // insert
            if ($id = $record->insert($data)) { // success
                $response['result'] = true;
                $response['id'] = $id;
                $response['message'] = Language::get(strtolower($class_name), 'insert_success');
            } else { // error db
                $response['message'] = Language::get('main', 'error_db');
                $response['result'] = false;
            }
        }
    } else {
        $response['result'] = false;
        $response['message'] = Language::get('main', 'error_fill_fields');
    }