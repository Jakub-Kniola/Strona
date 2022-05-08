<?php

    session_start();
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=utf-8');

    function error($message) {
        response(false, $message);
    }

    function success($message, $extra = []) {
        response(true, $message, $extra);
    }

    function response($success, $message, $extra = []) {
        #http_response_code($success ? 200 : 400);
        $res = ['success' => $success, 'message' => $message];
        if (!empty($extra)) $res = array_merge($res, $extra);
        echo json_encode($res);
    }