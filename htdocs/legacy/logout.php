<?php

    require_once 'session_required.php';

    unset($_SESSION['user_id']);
    echo 'Wylogowano!'; # Tutaj nalezy zaprogramować co wyświtlić lub gdzie przenieść uzytkownika jeśli wylogowanie się powodło.
