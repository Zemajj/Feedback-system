<?php
class Database {


   public function __construct(
       private string $host = 'ваш хост',
       private string $username = 'пользователь',
       private string $db_name = 'имя бд',
       private string $password = 'пароль',

   ) {}


    // Метод для подключения к БД
    public function connect() {


        try {
            $conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $stmt = $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Ошибка подключения: " . $exception->getMessage();
        }

        return $conn;
    }
}

