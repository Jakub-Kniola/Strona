<?php

    session_start();

    if (isset($_SESSION['user_id'])) { # Brak sesji jest wymagany (trzeba być niezalogowanym), aby wejść na daną stronę.
        header('Location: /index.php');
        return;
    }