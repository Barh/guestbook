<?php

    // id
    if (isset($_POST['id'])) {
        $record->setId($_POST['id']);
    }

    // before or after
    if (isset($_POST['before'])) {
        call_user_func(array($record, 'set'.($_POST['before'] ? 'Before' : 'After')));
    }

    // no limit
    if (isset($_POST['no_limit']) && $_POST['no_limit']) {
        $record->setNoLimit();
    }

    // success
    if ( $data = $record->getList() ) {
        // format time
        foreach ($data as $k=>$v) {
            $data[$k]['created'] = date('d.m.y H:i', strtotime($v['created']));
        }

        $response['result'] = true;
        $response['data']   = $data;
    } else {
        $response['result'] = false;
    }