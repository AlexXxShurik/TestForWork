<?php
// Функция для соединения с базой данных
function getDbConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "your_database_name"; // Замените на имя вашей базы данных

    // Создаем соединение
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Проверяем соединение
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Функция для создания таблиц
function createTable($tableName, $columns) {
    $conn = getDbConnection();

    // Создаем SQL-запрос для создания таблицы
    $columnsSql = implode(", ", $columns);
    $createTableSql = "CREATE TABLE IF NOT EXISTS $tableName ($columnsSql)";

    if ($conn->query($createTableSql) === TRUE) {
        echo "Table $tableName created successfully.<br>";
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }

    $conn->close();
}

// Функция для вставки данных в таблицу
function insertData($tableName, $data, $columns) {
    $conn = getDbConnection();

    // Определяем имена столбцов и плейсхолдеры
    $columnsSql = implode(", ", $columns);
    $placeholders = implode(", ", array_fill(0, count($columns), '?'));

    // Подготавливаем SQL-запрос для вставки данных
    $insertSql = "INSERT INTO $tableName ($columnsSql) VALUES ($placeholders)";
    $stmt = $conn->prepare($insertSql);

    if (!$stmt) {
        die("Preparation failed: " . $conn->error);
    }

    // Определяем типы данных для связывания
    $types = str_repeat('s', count($columns)); // Замените 's' на 'i', 'd' и т.д., если нужно

    // Проходим по данным и вставляем
    foreach ($data as $row) {
        $stmt->bind_param($types, ...array_values($row));
        $stmt->execute();
    }

    $stmt->close();
    $conn->close();
}

// Функция для получения данных из API
function fetchDataFromApi($endpoint) {
    $url = 'https://dummyjson.com/' . $endpoint;
    $response = file_get_contents($url);

    if ($response === FALSE) {
        die('Error fetching data from API');
    }

    return json_decode($response, true);
}

// Функция для получения и сохранения iPhones
function getAndSaveIphones() {
    $iphones = fetchDataFromApi('products');

    // Фильтруем только iPhones
    $iphones = array_filter($iphones['products'], function($product) {
        return strpos($product['name'], 'iPhone') !== false;
    });

    // Сохраняем iPhones в базе данных
    insertData('iphones', $iphones, ['id', 'name', 'price', 'description']);
}
?>
