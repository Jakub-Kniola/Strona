<?php
    
    require_once '../credentials.php';
    require_once '../application.php';

    if (!is_post()) {
        error('Użyto złej metody HTTP! Użyj metody POST!');
        return;
    }

    if (isset($_SESSION['user_id'])) {
        error('Jesteś już zalogowany!');
        return;
    }
    
    if (empty($_POST['email']) || empty($_POST['password'])) {
        error('Nie podano danych do logowania!');
        return;
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $fetched_user_id;
    $fetched_password;

    $connection = mysqli_connect(MYSQL_ADDRESS, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
    $statement = mysqli_prepare($connection, 'SELECT user_id, password FROM users WHERE email = ?');

    mysqli_stmt_bind_param($statement, 's', $email);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $fetched_user_id, $fetched_password);
    mysqli_stmt_fetch($statement);
    mysqli_stmt_close($statement);
    mysqli_close($connection);

    if (!$fetched_user_id) {
        error('Podano błędne dane do logowania!');
        return;
    }

    if (!password_verify($password, $fetched_password)) {
        error('Podano błędne dane do logowania!');
        return;
    }

    $_SESSION['user_id'] = $fetched_user_id;
    
    success('Użytkownik został zalogowany pomyślnie!');