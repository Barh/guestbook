<?php

    // get page
    $page = Parameters::get();

    // incorrect
    if (Parameters::$incorrect) {
        Parameters::incorrect();
    }

    // correct parameters
    if ( $page ) {
        switch ($page[0]) {
            // notes
            case 'notes':
                // is notes type
                if (isset($page[1])) {
                    if (is_numeric($page[1])) { // id
                        // is
                        if (isset($page[2])) {
                            switch ($page[2]) {
                                // comments
                                case 'comments':
                                    if (isset($page[3])) {
                                        switch ($page[3]) {
                                            // insert
                                            case 'insert':
                                                // correct data
                                                if ($data = Parameters::filter($_POST, array('email', 'text'), true)) {
                                                    // note id
                                                    $data['note_id'] = (int)$page[1];

                                                    // no empty
                                                    if (!empty($data['email']) && !empty($data['text']) ) {
                                                        if ($id = NotesComments::insert($data)) {
                                                            $response['result'] = true;
                                                            $response['id'] = $id;
                                                            $response['message'] = Language::get('notes_comments', 'insert_success');
                                                        } else {
                                                            $response['message'] = Language::get('main', 'error_db');
                                                            $response['result'] = false;
                                                        }
                                                    } else {
                                                        $response['result'] = false;
                                                        $response['message'] = Language::get('main', 'error_fill_fields');
                                                    }

                                                    // print json string
                                                    ob_get_clean();
                                                    echo json_encode($response);
                                                    exit;
                                                }
                                                break;
                                            // incorrect
                                            default:
                                                Parameters::incorrect();
                                                break;
                                        }
                                    } else { // get list

                                        // get arguments
                                        $args['note_id'] = $page[1];
                                        foreach (array('id', 'before', 'no_limit') as $v) {
                                            if (isset($_POST[$v])) {
                                                $args[] = (int)$_POST[$v];
                                            }
                                        }

                                        // success
                                        if ($data = call_user_func_array('NotesComments::getList', $args)) {
                                            $response['result'] = true;
                                            $response['data'] = $data;
                                        } else {
                                            $response['result'] = false;
                                        }

                                        // print json string
                                        ob_get_clean();
                                        echo json_encode($response);
                                        exit;
                                    }
                                    break;
                                // incorrect
                                default:
                                    Parameters::incorrect();
                                    break;
                            }
                        }
                    } else { // operation
                        switch ($page[1]) {
                            // insert
                            case 'insert':
                                // correct data
                                if ($data = Parameters::filter($_POST, array('name', 'email', 'text'), true)) {
                                    // no empty
                                    if (!empty($data['name']) && !empty($data['email']) && !empty($data['text']) ) {
                                        if ($id = Notes::insert($data)) {
                                            $response['result'] = true;
                                            $response['id'] = $id;
                                            $response['message'] = Language::get('notes', 'insert_success');
                                        } else {
                                            $response['message'] = Language::get('main', 'error_db');
                                            $response['result'] = false;
                                        }
                                    } else {
                                        $response['result'] = false;
                                        $response['message'] = Language::get('main', 'error_fill_fields');
                                    }

                                    // print json string
                                    ob_get_clean();
                                    echo json_encode($response);
                                    exit;
                                }
                                break;
                            // incorrect
                            default:
                                Parameters::incorrect();
                                break;
                        }
                    }
                } else { // get list

                    // get arguments
                    $args = array();
                    foreach (array('id', 'before', 'no_limit') as $v) {
                        if (isset($_POST[$v])) {
                            $args[] = (int)$_POST[$v];
                        }
                    }

                    // success
                    if ($data = call_user_func_array('Notes::getList', $args)) {
                        $response['result'] = true;
                        $response['data'] = $data;
                    } else {
                        $response['result'] = false;
                    }

                    // print json string
                    ob_get_clean();
                    echo json_encode($response);
                    exit;
                }
                break;
            // incorrect
            default:
                Parameters::incorrect();
                break;
        }

    }