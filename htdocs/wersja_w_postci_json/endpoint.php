<?php

    function error($message) {
        response(false, $message);
    }

    function success($message) {
        response(true, $message);
    }

    function response($success, $message) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($success ? 200 : 400);
        echo json_encode(['success' => $success, 'message' => $message]);
    }