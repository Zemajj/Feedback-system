<?php
class Review {
private $conn;
    // Конструктор принимает подключение к БД
    public function __construct($db) {
        $this->conn = $db;
    }

    // Проверка существования клиента
    public function clientID($client_id) {
        $query = ("SELECT COUNT(*) FROM `reviews` WHERE id = :client_id");
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':client_id', $client_id);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Сохранение отзыва
    public function saveReview($client_id, $rating, $comment) {
        $query = ("INSERT INTO `reviews` (client_id, rating, comment) VALUES (:client_id, :rating, :comment");
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':client_id', $client_id);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':comment', $comment);
        return $stmt->execute();
    }

}

