<?php
include_once 'database.php';
include_once 'Review.php';

// Получаем client_id из URL
$client_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Подключаемся к базе данных
$database = new Database();
$db = $database->connect();

// Создаем экземпляр ReviewService
$review = new Review($db);

// Проверяем, существует ли клиент
if (!$review->clientID($client_id)) {
    // Если клиент не найден, выводим сообщение
    echo "Ссылка на голосование недоступна, свяжитесь с нами по телефону!";
    exit;
}

// Обработка формы
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

    // Валидация данных
    if ($rating < 1 || $rating > 5) {
        echo "Оценка должна быть от 1 до 5.";
    } else {
        // Сохраняем отзыв
        if ($review->saveReview($client_id, $rating, $comment)) {
            echo "Спасибо за ваш отзыв!";
        } else {
            echo "Ошибка при сохранении отзыва.";
        }
        // Формат комментария
        if (preg_match('/^[a-zA-Z0-9\s.,!?]+$/', $comment)) {
            echo "Верный формат комментария!";
        } else {
            echo "Неверный формат комментария";
        }
    }

}
?>

<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Оставьте отзыв</title>
</head>
<body>
<h1>Оцените качество обслуживания</h1>
<form   method="post">
    <label>Оцените работу (1-5):</label><br>
    <input type="radio" name="rating" value="1"> 1
    <input type="radio" name="rating" value="2"> 2
    <input type="radio" name="rating" value="3"> 3
    <input type="radio" name="rating" value="4"> 4
    <input type="radio" name="rating" value="5"> 5<br><br>

    <label>При желании оставьте комментарий к отзыву:</label><br>
    <textarea name="comment" rows="4" cols="50" maxlength="150"></textarea><br><br>

    <input type="submit" value="Отправить отзыв">
</form>
</body>
</html>
