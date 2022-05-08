<?php

    require_once '../database_credentials.php';
    require_once '../rest_base.php';

    if (!isset($_SESSION['user_id'])) {
        error('Nie jesteś zalogowany!');
        return;
    }

    unset($_SESSION['user_id']);
    success('Wylogowano pomyślnie!');