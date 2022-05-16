<?php

    require_once '../database_credentials.php';
    require_once '../rest_base.php';

    if (!is_post()) {
        error('Użyto złej metody HTTP! Użyj metody POST!');
        return;
    }

    if (!isset($_SESSION['user_id'])) {
        error('Nie jesteś zalogowany!');
        return;
    }

    if (empty($_POST['new_name']) || empty($_POST['new_email']) || empty($_POST['new_password']) || empty($_POST['current_password'])) {
        error('Nie podano danych do akutalizacji!');
        return;
    }

    $user_id = $_SESSION['user_id'];
    $new_name = $_POST['new_name'];
    $new_email = $_POST['new_email'];
    $new_password = $_POST['new_password'];
    $current_password = $_POST['current_password'];

    if (strlen($new_name) < 3 || strlen($new_name) > 128) {
        error('Nazwa użytkownika musi posiadać od 3 do 128 znaków!');
        return;
    }

    if (strlen($new_email) < 6 || strlen($new_email) > 128) {
        error('Adres email musi posiadać od 6 do 128 znaków!');
        return;
    }

    if (strlen($new_password) < 8 || strlen($new_password) > 128) {
        error('Hasło musi posiadać od 8 do 128 znaków!');
        return;
    }

    if (!ctype_alnum($new_name)) {
        error('Nazwa użytkonika może zawierać tylko litery i cyfry!');
        return;
    }

    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        error('Podany adres email jest nieprawidłowy!');
        return;
    }

    $fetched_user_id;
    $fetched_current_password;

    $connection = mysqli_connect(MYSQL_ADDRESS, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
    $statement = mysqli_prepare($connection, 'SELECT password FROM users WHERE user_id = ?');

    mysqli_stmt_bind_param($statement, 'i', $user_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $fetched_current_password);
    mysqli_stmt_fetch($statement);
    mysqli_stmt_close($statement);

    if (!password_verify($current_password, $fetched_current_password)) {
        mysqli_close($connection);
        
        error('Podane aktualne hasło jest nieprawidłowe!');
        return;
    }

    $statement = mysqli_prepare($connection, 'SELECT user_id FROM users WHERE user_id != ? AND email = ?');

    mysqli_stmt_bind_param($statement, 'is', $user_id, $new_email);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $fetched_user_id);
    mysqli_stmt_fetch($statement);
    mysqli_stmt_close($statement);

    if ($fetched_user_id) {
        mysqli_close($connection);

        error('Podany adres email jest już zajęty!');
        return;
    }

    $new_password = password_hash($new_password, PASSWORD_BCRYPT);
    $statement = mysqli_prepare($connection, 'UPDATE users SET name = ?, email = ?, password = ? WHERE user_id = ?');

    mysqli_stmt_bind_param($statement, 'sssi', $new_name, $new_email, $new_password, $user_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);
    mysqli_close($connection);

    success('Dane zostały pomyślnie zaktualizowane!');

