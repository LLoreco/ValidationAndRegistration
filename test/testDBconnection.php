<?php
require_once __DIR__ . '/../backend/database/database.php';

$db = new Database();
$connection = $db->connect();

if ($connection) {
    echo " Подключение к PostgreSQL успешно!\n";
} else {
    echo " Ошибка подключения к PostgreSQL\n";
    exit;
}

try {
    $query = "SELECT * FROM users LIMIT 1";
    $stmt = $connection->query($query);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo " Данные из таблицы users получены. Пример: " . print_r($user, true) . "\n";
    } else {
        echo " Таблица users пуста или не существует\n";
    }
} catch (PDOException $e) {
    echo " Ошибка запроса к таблице users: " . $e->getMessage() . "\n";
}
?>