<?php

    require_once '../credentials.php';
    require_once '../application.php';

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
    $phone = $_POST['phone'] ?? null;
    $birthday = $_POST['birthday'] ?? null;
    $password = $_POST['password'] ?? null;
    $verification = $_POST['verification'] ?? null;

    if (empty($name) && empty($email) && empty($phone) && empty($birthday) && empty($password)) {
        error('Nie podano danych do aktualizacji!');
        return;
    }

    if (empty($verification)) {
        error('Nie podano akualnego hasła!');
        return;
    }

    if (isset($name) && (strlen($name) < 3 || strlen($name) > 64)) {
        error('Nazwa użytkownika musi posiadać od 3 do 64 znaków!');
        return;
    }

    if (isset($email) && (strlen($email) < 6 || strlen($email) > 64)) {
        error('Adres email musi posiadać od 6 do 64 znaków!');
        return;
    }

    if (isset($phone) && (strlen($phone) < 9 || strlen($phone) > 16)) {
        error('Numer telefonu musi posiadać od 9 do 16 znaków!');
        return;
    }

    if (isset($password) && (strlen($password) < 8 || strlen($password) > 256)) {
        error('Hasło musi posiadać od 8 do 256 znaków!');
        return;
    }

    if (isset($name) && (!ctype_alnum($name))) {
        error('Nazwa użytkonika może zawierać tylko litery i cyfry!');
        return;
    }

    if (isset($phone) && (!ctype_digit($phone))) {
        error('Numer telefonu może zawierać tylko cyfry!');
        return;
    }

    if (isset($birthday) && (!validate_date($birthday))) {
        error('Podana data urodzenia jest nieprawidłowa!');
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
    $fetched_phone;
    $fetched_birthday;
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

    $statement = mysqli_prepare($connection, 'SELECT name, email, phone, birthday, password FROM users WHERE user_id = ?');

    mysqli_stmt_bind_param($statement, 'i', $user_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $fetched_name, $fetched_email, $fetched_phone, $fetched_birthday, $fetched_password);
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
    $phone = $phone ?? $fetched_phone;
    $birthday = $birthday ?? $fetched_birthday;
    $password = $password ?? $fetched_password;

    $statement = mysqli_prepare($connection, 'UPDATE users SET name = ?, email = ?,  phone = ?, birthday = ?, password = ? WHERE user_id = ?');

    mysqli_stmt_bind_param($statement, 'sssssi', $name, $email, $phone, $birthday, $password, $user_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);
    mysqli_close($connection);

    success('Dane użytkownika zostały zaktualizowane pomyślnie!');