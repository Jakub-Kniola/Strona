<?php

    require_once '../database_credentials.php';
    require_once '../rest_base.php';

    if (!is_get()) {
        error('Użyto złej metody HTTP! Użyj metody GET!');
        return;
    }

    if (!isset($_SESSION['user_id'])) {
        error('Nie jesteś zalogowany!');
        return;
    }

    $user_id = $_SESSION['user_id'];

    $products = [];

    $connection = mysqli_connect(MYSQL_ADDRESS, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
    $statement = mysqli_prepare($connection, 'SELECT purchase.purchase_id, purchase.product_id, products.title, products.subtitle, products.publisher, products.released, products.icon, purchase.price as purchase_price, purchase.date as purchase_date FROM purchase INNER JOIN products ON purchase.product_id = products.product_id WHERE user_id = ?');

    mysqli_stmt_bind_param($statement, 'i', $user_id);
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);

    while ($product = mysqli_fetch_assoc($result)) {
        array_push($products, $product);
    }

    mysqli_stmt_close($statement);
    mysqli_close($connection);

    success('Zwórocono pomyślnie listę zakupionych przedmiotów!', ['products' => $products]);