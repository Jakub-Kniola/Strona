<?php
    
    require_once '../database_credentials.php';
    require_once 'endpoint.php';

    session_start();

    if (isset($_SESSION['user_id'])) {
        error('Jesteś już zalogowany!');
        return;
    }
    
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        error('Nie podano danych do logowania!');
        return;
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $connection = mysqli_connect(MYSQL_ADDRESS, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
    $statement = mysqli_prepare($connection, 'SELECT user_id, password FROM users WHERE email = ?');

    mysqli_stmt_bind_param($statement, 's', $email);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);

    if (!mysqli_stmt_num_rows($statement)) {
        mysqli_stmt_close($statement);
        mysqli_close($connection);
        
        error('Podano błędne dane do logowania!');
        return;
    }

    $fetched_user_id;
    $fetched_password;

    mysqli_stmt_bind_result($statement, $fetched_user_id, $fetched_password);
    mysqli_stmt_fetch($statement);
    mysqli_stmt_close($statement);
    mysqli_close($connection);

    if (!password_verify($password, $fetched_password)) {
        error('Podano błędne dane do logowania!');
        return;
    }

    $_SESSION['user_id'] = $fetched_user_id;
    success('Zalogowano pomyślnie!');

?>