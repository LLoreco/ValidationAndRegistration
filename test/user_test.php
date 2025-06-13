<?php
require_once __DIR__ . '/../backend/models/user.php';

// Инициализация
$user = new User();

// Тест 1: Регистрация нового пользователя
echo "Тест 1: Регистрация\n";
$result = $user->register('testuser', 'test@example.com', 'secure123');
print_r($result);
echo "\n";

// Тест 2: Попытка повторной регистрации
echo "Тест 2: Повторная регистрация\n";
$result = $user->register('testuser', 'test@example.com', 'secure123');
print_r($result);
echo "\n";

// Тест 3: Вход с правильными данными
echo "Тест 3: Успешный вход\n";
$result = $user->login('test@example.com', 'secure123');
print_r($result);
echo "\n";

// Тест 4: Вход с неверным паролем
echo "Тест 4: Неверный пароль\n";
$result = $user->login('test@example.com', 'wrongpass');
print_r($result);
echo "\n";

// Тест 5: Вход с несуществующим email
echo "Тест 5: Несуществующий email\n";
$result = $user->login('nonexistent@example.com', 'pass123');
print_r($result);
echo "\n";

// Тест 6: Регистрация с пустыми полями
echo "Тест 6: Пустые поля\n";
$result = $user->register('', '', '');
print_r($result);
echo "\n";

// Тест 7: Неверный формат email
echo "Тест 7: Неверный email\n";
$result = $user->register('user2', 'notanemail', 'pass123');
print_r($result);
echo "\n";

// Тест 8: Короткий пароль
echo "Тест 8: Короткий пароль\n";
$result = $user->register('user3', 'user3@example.com', '123');
print_r($result);
?>