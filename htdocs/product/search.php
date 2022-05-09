<?php

    require_once '../database_credentials.php';
    require_once '../rest_base.php';

    if (!is_get()) {
        error('Użyto złej metody HTTP! Użyj metody GET!');
        return;
    }

    if (empty($_GET['search'])) {
        error('Nie podatno szukanej frazy!');
        return;
    }

    $search = '%' . $_GET['search'] . '%';

    $products = [];

    $connection = mysqli_connect(MYSQL_ADDRESS, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
    $statement = mysqli_prepare($connection, 'SELECT product_id, title, subtitle, price, publisher, released FROM products WHERE title LIKE ? OR subtitle LIKE ?');

    mysqli_stmt_bind_param($statement, 'ss', $search, $search);
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);

    while ($product = mysqli_fetch_assoc($result)) {
        array_push($products, $product);
    }

    mysqli_stmt_close($statement);
    mysqli_close($connection);

    success('Zwórocono pomyślnie listę produktów pasujących do podanej frazy!', ['products' => $products]);