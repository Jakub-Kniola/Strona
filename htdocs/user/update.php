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

    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $verification = $_POST['verification'] ?? null;

    if (empty($name) && empty($email) && empty($password)) {
        error('Nie podano danych do aktualizacji!');
        return;
    }

    if (empty($verification)) {
        error('Nie podano akualnego hasła!');
        return;
    }

    if (isset($name) && (strlen($name) < 3 || strlen($name) > 128)) {
        error('Nazwa użytkownika musi posiadać od 3 do 128 znaków!');
        return;
    }

    if (isset($email) && (strlen($email) < 6 || strlen($email) > 128)) {
        error('Adres email musi posiadać od 6 do 128 znaków!');
        return;
    }

    if (isset($password) && (strlen($password) < 8 || strlen($password) > 128)) {
        error('Hasło musi posiadać od 8 do 128 znaków!');
        return;
    }

    if (isset($name) && (!ctype_alnum($name))) {
        error('Nazwa użytkonika może zawierać tylko litery i cyfry!');
        return;
    }

    if (isset($email) && (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
        error('Podany adres email jest nieprawidłowy!');
        return;
    }

    $user_id = $_SESSION['user_id'];

    $fetched_user_id;
    $fetched_name;
    $fetched_email;
    $fetched_password;

    $connection = mysqli_connect(MYSQL_ADDRESS, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
    $statement = mysqli_prepare($connection, 'SELECT user_id FROM users WHERE user_id != ? AND email = ?');

    if (isset($email)) {
        mysqli_stmt_bind_param($statement, 'is', $user_id, $email);
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
    }

    $statement = mysqli_prepare($connection, 'SELECT name, email, password FROM users WHERE user_id = ?');

    mysqli_stmt_bind_param($statement, 'i', $user_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $fetched_name, $fetched_email, $fetched_password);
    mysqli_stmt_fetch($statement);
    mysqli_stmt_close($statement);

    if (!password_verify($verification, $fetched_password)) {
        mysqli_close($connection);

        error('Podane akutalne hasło jest niepoprawne!');
        return;
    }

    if (isset($password)) {
        $password = password_hash($password, PASSWORD_BCRYPT);
    }

    $name = $name ?? $fetched_name;
    $email = $email ?? $fetched_email;
    $password = $password ?? $fetched_password;

    $statement = mysqli_prepare($connection, 'UPDATE users SET name = ?, email = ?, password = ? WHERE user_id = ?');

    mysqli_stmt_bind_param($statement, 'sssi', $name, $email, $password, $user_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);
    mysqli_close($connection);

    success('Dane użytkownika zostały zaukualizowane pomyślnie!');