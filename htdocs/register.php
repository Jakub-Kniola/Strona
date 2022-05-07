<?php

    require_once 'session_absence.php';
    require_once 'database_credentials.php';

    $errors = [];

    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $captcha = $_POST['g-recaptcha-response'];

        if (strlen($name) < 3 || strlen($name) > 128) array_push($errors, 'Imie i naziwsko musi mieć od 3 do 128 znaków!');
        if (strlen($email) < 6 || strlen($email) > 128) array_push($errors, 'Email musi mieć od 6 do 128 znaków!');
        if (strlen($password) < 8 || strlen($password) > 128) array_push($errors, 'Hasło musi mieć od 8 do 128 znaków!');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) array_push($errors, 'Podany email jest niepoprawny!');
        if (empty($captcha)) array_push($errors, 'Zaznacz pole captcha!');

        if (empty($errors)) {
            $password = password_hash($password, PASSWORD_BCRYPT);
            $verification = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Ld1GVYUAAAAAHKGr2rKy7TmGG9WyUPcwcn3UqXy&response=$captcha");

            if (!json_decode($verification)->success) {
                array_push($errors, 'Nie można zweryfikować captcha!');
            }

            if (empty($errors)) {
                $connection = mysqli_connect(MYSQL_ADDRESS, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
                $statement = mysqli_prepare($connection, 'SELECT user_id FROM users WHERE email = ?');

                mysqli_stmt_bind_param($statement, 's', $email);
                mysqli_stmt_execute($statement);
                mysqli_stmt_store_result($statement);

                if (mysqli_stmt_num_rows($statement)) {
                    array_push($errors, 'Podany email jest już zajęty!');
                }

                if (empty($errors)) {
                    mysqli_stmt_close($statement);

                    $statement = mysqli_prepare($connection, 'INSERT INTO users VALUES (NULL, ?, ?, ?)');
                    
                    mysqli_stmt_bind_param($statement, 'sss', $name, $email, $password);
                    mysqli_stmt_execute($statement);
                    mysqli_stmt_close($statement);
                    mysqli_close($connection);

                    echo 'Zarejestrowano!'; # Tutaj nalezy zaprogramować co wyświtlić lub gdzie przenieść uzytkownika jeśli rejestracja się powodła.
                    return;
                }

                mysqli_close($connection);
            }
        }
    }
?>

<!-- Poniżej będzie kod szablonu strony -->
<html>
    <html>
        <meta charset="utf-8">
        <script src="https://www.google.com/recaptcha/api.js"></script>
    </html>
    <body>
        <div>
            <?php
            if (!empty($errors)) {
                echo 'Błędy:<br>' . implode('<br>', $errors) . '<br><br>';
            }
            ?>
        </div>
        <form method="POST" action="register.php">
            <input name="name" type="text" placeholder="Imie i naziwsko" value="<?php echo (isset($_POST['name']) ? $_POST['name'] : '') ?>" required>
            <input name="email" type="email" placeholder="Email" value="<?php echo (isset($_POST['email']) ? $_POST['email'] : '') ?>" required>
            <input name="password" type="password" placeholder="Hasło" value="<?php echo (isset($_POST['password']) ? $_POST['password'] : '') ?>" required>
            <input type="submit" value="Zarejestruj"><br><br>
            <div class="g-recaptcha" data-sitekey="6Ld1GVYUAAAAAHe1v6NmUO1_9oqgHgROk_QKNdup" data-theme="dark"></div>
        </form>
    </body>
</html>
