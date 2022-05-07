<?php

    require_once 'database_credentials.php';

    if (isset($_SESSION['user_id'])) {
        header('Location: index.php');
        return;
    }

    $message;

    if (isset($_POST['email']) && isset($_POST['password'])) {
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
            
            $message = 'Podano błędne dane logowania!';
        }

        if (empty($message)) {
            $fetched_user_id;
            $fetched_password;

            mysqli_stmt_bind_result($statement, $fetched_user_id, $fetched_password);
            mysqli_stmt_fetch($statement);
            mysqli_stmt_close($statement);
            mysqli_close($connection);

            if (!password_verify($password, $fetched_password)) {
                $message = 'Podano błędne dane logowania!';
            }

            if (empty($message)) {
                $_SESSION['user_id'] = $fetched_user_id;
                echo 'Zalogowano!';
                return;
            }
        }
    }

?>