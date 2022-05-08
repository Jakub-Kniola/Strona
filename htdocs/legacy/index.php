<?php

    # Przykładowa strony do stpawdzenia czy logowanie działa poprawnie.

    session_start();
    require_once 'database_credentials.php';

    if (isset($_SESSION['user_id'])) {
        $connection = mysqli_connect(MYSQL_ADDRESS, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
        $statement = mysqli_prepare($connection, 'SELECT name, email FROM users WHERE user_id = ?');

        $user_id = $_SESSION['user_id'];

        mysqli_stmt_bind_param($statement, 's', $user_id);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);

        if (!mysqli_stmt_num_rows($statement)) {
            die('cos jest zle!');
        }

        $fetched_name;
        $fetched_email;

        mysqli_stmt_bind_result($statement, $fetched_name, $fetched_email);
        mysqli_stmt_fetch($statement);
        mysqli_stmt_close($statement);
        mysqli_close($connection);

        echo 'Witaj ' . $fetched_name . ' - ' . $fetched_email . '! <br> <a href="/logout.php">Wyloguj</a>';
    } else {
        echo 'Witaj! <br> <a href="/login.php">Zaloguj</a> | <a href="/register.php">Zarejetruj</a>';
    }