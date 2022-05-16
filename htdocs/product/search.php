<?php

    require_once '../database_credentials.php';
    require_once '../rest_base.php';

    error_reporting(E_ALL);

    if (!is_get()) {
        error('Użyto złej metody HTTP! Użyj metody GET!');
        return;
    }

    $query = 'SELECT product_id, title, subtitle, publisher, released, icon, price, discount FROM products ';

    $types = [];
    $values = [];
    $conditions = [];
    $products = [];

    $offset = $_GET['offset'] ?? null;
    $limit = $_GET['limit'] ?? null;

    if (isset($_GET['title'])) add_query_condition('%'.$_GET['title'].'%', 's', 'title LIKE ?');
    if (isset($_GET['category'])) add_query_condition($_GET['category'], 's', 'category = ?');
    if (isset($_GET['publisher'])) add_query_condition($_GET['publisher'], 's', 'publisher = ?');
    if (isset($_GET['released'])) add_query_condition($_GET['released'], 'i', 'released = ?');
    if (isset($_GET['discounted'])) add_query_condition(null, null, 'discount > 0.0');
    if (isset($_GET['min_price'])) add_query_condition($_GET['min_price'], 'i', 'price >= ?');
    if (isset($_GET['max_price'])) add_query_condition($_GET['max_price'], 'i', 'price <= ?');

    if (!empty($conditions)) {
        $query .= 'WHERE ' . implode(' AND ', $conditions);
    }

    if (isset($limit) && isset($offset)) {
        $query .= ' LIMIT ?, ?';
        array_push($types, 'i', 'i');
        array_push($values, $offset, $limit);
    }

    $connection = mysqli_connect(MYSQL_ADDRESS, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
    $statement = mysqli_prepare($connection, $query);

    if (!empty($types)) mysqli_stmt_bind_param($statement, implode('', $types), ...$values);
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);

    while ($product = mysqli_fetch_assoc($result)) {
        array_push($products, $product);
    }

    mysqli_stmt_close($statement);
    mysqli_close($connection);

    success('Zwórocono pomyślnie listę produktów pasujących do podanej danych!', ['products' => $products]);


    function add_query_condition($value, $type, $condition) {
        global $types, $values, $conditions;

        if (!empty($value) && !empty($type)) {
            array_push($types, $type);
            array_push($values, $value);
        }

        array_push($conditions, $condition);
    }