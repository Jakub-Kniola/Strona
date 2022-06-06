<?php

    require_once '../credentials.php';
    require_once '../application.php';

    if (!is_get()) {
        error('Użyto złej metody HTTP! Użyj metody GET!');
        return;
    }

    if (!isset($_SESSION['user_id'])) {
        error('Nie jesteś zalogowany!');
        return;
    }

    $user_id = $_SESSION['user_id'];

    $connection = mysqli_connect(MYSQL_ADDRESS, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
    $statement = mysqli_prepare($connection, 'SELECT user_id, name, email, phone, birthday FROM users WHERE user_id = ?');

    mysqli_stmt_bind_param($statement, 'i', $user_id);
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);
    $user = mysqli_fetch_assoc($result);

    mysqli_stmt_close($statement);
    mysqli_close($connection);
    
    success('Dane użytkownika zostały zwrócone pomyślnie!', ['user' => $user]);