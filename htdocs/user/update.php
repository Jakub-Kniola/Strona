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

    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirmation'])) {
        error('Nie podano danych do akutalizacji!');
        return;
    }

    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmation = $_POST['confirmation'];

    if (strlen($name) < 3 || strlen($name) > 128) {
        error('Nazwa użytkownika musi posiadać od 3 do 128 znaków!');
        return;
    }

    if (strlen($email) < 6 || strlen($email) > 128) {
        error('Adres email musi posiadać od 6 do 128 znaków!');
        return;
    }

    if (strlen($password) < 8 || strlen($password) > 128) {
        error('Hasło musi posiadać od 8 do 128 znaków!');
        return;
    }

    if (!ctype_alnum($name)) {
        error('Nazwa użytkonika może zawierać tylko litery i cyfry!');
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        error('Podany adres email jest niepoprawny!');
        return;
    }

    $fetched_name;
    $fetched_email;
    $fetched_password;

    $connection = mysqli_connect(MYSQL_ADDRESS, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
    $statement = mysqli_prepare($connection, 'SELECT name, email, password FROM users WHERE user_id = ?');

    mysqli_stmt_bind_param($statement, 'i', $user_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $fetched_name, $fetched_email, $fetched_password);
    mysqli_stmt_fetch($statement);
    mysqli_stmt_close($statement);

    if (!password_verify($confirmation, $fetched_password)) {
        error('Podane aktualne hasło jest niepoprawne!');
        return;
    }

    $password = password_hash($password, PASSWORD_BCRYPT);
    $statement = mysqli_prepare($connection, 'UPDATE users SET name = ?, email = ?, password = ? WHERE user_id = ?');

    mysqli_stmt_bind_param($statement, 'sssi', $name, $email, $password, $user_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);
    mysqli_close($connection);

    success('Dane zostały pomyślnie zaktualizowane!');

