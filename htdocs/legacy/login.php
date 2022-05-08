<?php
    
    require_once 'session_absence.php';
    require_once 'database_credentials.php';

    $errors = [];

    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $connection = mysqli_connect(MYSQL_ADDRESS, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
        $statement = mysqli_prepare($connection, 'SELECT user_id, password FROM users WHERE email = ?');

        mysqli_stmt_bind_param($statement, 's', $email);
        mysqli_stmt_execute($statement);
        mysqli_stmt_store_result($statement);

        if (!mysqli_stmt_num_rows($statement)) {
            array_push($errors, 'Podano błędne dane logowania!');
        }

        if (empty($errors)) {
            $fetched_user_id;
            $fetched_password;

            mysqli_stmt_bind_result($statement, $fetched_user_id, $fetched_password);
            mysqli_stmt_fetch($statement);
            mysqli_stmt_close($statement);
            mysqli_close($connection);

            if (!password_verify($password, $fetched_password)) {
                array_push($errors, 'Podano błędne dane logowania!');
            }

            if (empty($errors)) {
                $_SESSION['user_id'] = $fetched_user_id;
                echo 'Zalogowano!'; # Tutaj nalezy zaprogramować co wyświtlić lub gdzie przenieść uzytkownika jeśli logowanie się powodło.
                return;
            }
        }
    }

?>

<!-- Poniżej będzie kod szablonu strony -->
<html>
    <html>
        <meta charset="utf-8">
    </html>
    <body>
        <div>
            <?php
            if (!empty($errors)) {
                echo 'Błędy:<br>' . implode('<br>', $errors) . '<br><br>';
            }
            ?>
        </div>
        <form method="POST" action="login.php">
            <input name="email" type="email" placeholder="Email" value="<?php echo (isset($_POST['email']) ? $_POST['email'] : '') ?>" required>
            <input name="password" type="password" placeholder="Hasło" value="<?php echo (isset($_POST['password']) ? $_POST['password'] : '') ?>" required>
            <input type="submit" value="Zaloguj"><br><br>
        </form>
    </body>
</html>