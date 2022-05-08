<?php

    session_start();

    if (!isset($_SESSION['user_id'])) { # Sesja jest wymagana (trzeba być zalogowanym), aby wejść na daną stronę.
        header('Location: /login.php');
        return;
    }