<?php

    session_start();
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=utf-8');

    function error($message) {
        response(false, $message, 400);
    }

    function success($message, $extra = []) {
        response(true, $message, 200, $extra);
    }

    function is_post() {
        return strcmp($_SERVER['REQUEST_METHOD'], 'POST') == 0;
    }

    function is_get() {
        return strcmp($_SERVER['REQUEST_METHOD'], 'GET') == 0;
    }

    function response($success, $message, $code, $extra = []) {
        http_response_code($code);
        $res = ['success' => $success, 'message' => $message];
        if (!empty($extra)) $res = array_merge($res, $extra);
        echo json_encode($res);
    }