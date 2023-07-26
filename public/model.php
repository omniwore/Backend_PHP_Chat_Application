<?php
require_once __DIR__ . '/../vendor/autoload.php';
class Model{
    public function getUsers($data) {
        
        $database = new \Ogunerkutay\ChatBackend\Database();
        $connection = $database->getConnection();

        $query = 'SELECT * FROM users WHERE username = :username';
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':username', $data['username']);
        $stmt->execute();
        $fetchRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fetchRow;
    }

    public function addnewUsers($data){
        $database = new \Ogunerkutay\ChatBackend\Database();
        $connection = $database->getConnection();

        $query = 'INSERT INTO users (username, password) VALUES (:username, :password)';
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':username', $data['username']);
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();
    }

    public function getGroups($data) {
        
        $database = new \Ogunerkutay\ChatBackend\Database();
        $connection = $database->getConnection();

        $query = 'SELECT * FROM groups WHERE group_id = :group_id';
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':group_id', $data['group_id']);
        $stmt->execute();
        $fetchRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fetchRow;
    }

    public function addnewGroups($data){
        $database = new \Ogunerkutay\ChatBackend\Database();
        $connection = $database->getConnection();

        $query = 'INSERT INTO groups (user_id, group_name, group_id, timestamp) VALUES (:user_id, :group_name, :group_id, :timestamp)';
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':group_name', $data['group_name']);
        $stmt->bindParam(':group_id', $data['group_id']);
        $created_at = time();
        $stmt->bindParam(':timestamp', $created_at);
        $res = $stmt->execute();
    }

    public function getUsers_Groups($data) {
        
        $database = new \Ogunerkutay\ChatBackend\Database();
        $connection = $database->getConnection();

        $query = 'SELECT user_id || "-" || group_id AS combined_id FROM user_groups WHERE group_id = :group_id AND user_id = :user_id';
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':group_id', $data['group_id']);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->execute();
        $fetchRow = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fetchRow;
    }

    public function addUser_Groups($data){
        $database = new \Ogunerkutay\ChatBackend\Database();
        $connection = $database->getConnection();

        $query = 'INSERT INTO user_groups (user_id, group_id, timestamp) VALUES (:user_id, :group_id, :timestamp)';
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':group_id', $data['group_id']);
        $created_at = time();
        $stmt->bindParam(':timestamp', $created_at);
        $stmt->execute();
    }

    public function saveMessage($data){
        $database = new \Ogunerkutay\ChatBackend\Database();
        $connection = $database->getConnection();

        $query = 'INSERT INTO messagess (user_id, content, group_id, timestamp) VALUES (:user_id, :content, :group_id, :timestamp)';
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':group_id', $data['group_id']);
        $stmt->bindValue(':timestamp', time());
        $stmt->execute();

    }

    public function fetchMessage($data){
        $database = new \Ogunerkutay\ChatBackend\Database();
        $connection = $database->getConnection();

        $query = 'SELECT * FROM messagess WHERE group_id = :group_id';
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':group_id', $data['group_id']);
        $stmt->execute();
        $messages = $stmt->fetchALL(PDO::FETCH_ASSOC);
        return $messages;
    }
}
