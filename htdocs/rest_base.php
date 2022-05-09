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

    function json_data() {
        return json_decode(file_get_contents('php://input'), true);
    }

    function response($success, $message, $code, $extra = []) {
        http_response_code($code);

        $response = ['success' => $success, 'message' => $message];

        if (!empty($extra)) {
            $response = array_merge($response, $extra);
        }

        echo json_encode($response);
    }