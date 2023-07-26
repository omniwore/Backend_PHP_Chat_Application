<?php

namespace Ogunerkutay\ChatBackend;

use PDO;

class Database
{
    private $connection;

    public function __construct()
    {
        $this->connect();
        $this->createTables();
    }
    

    private function connect()
    {
        $databaseFile = __DIR__ . '/../../database/chat.sqlite';
        $this->connection = new PDO('sqlite:' . $databaseFile);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    }

    public function getConnection()
    {

        return $this->connection;
    }

    public function createTables()
{
    $this->connection->exec(
        "CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY,
            username TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL
        );"
    );

    $this->connection->exec(
        "CREATE TABLE IF NOT EXISTS groups (
            id INTEGER PRIMARY KEY,
            group_name TEXT NOT NULL,
            group_id INTEGER NOT NULL,
            timestamp INTEGER NOT NULL,
            FOREIGN KEY (group_id) REFERENCES groups (id)
        );"
    );

    $this->connection->exec(
        "CREATE TABLE IF NOT EXISTS messagess (
            id INTEGER PRIMARY KEY,
            user_id INTEGER NOT NULL,
            content TEXT NOT NULL,
            group_id INTEGER NOT NULL,
            timestamp INTEGER NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users (id)
            FOREIGN KEY (group_id) REFERENCES groups (id)
        );"
    );
    
    $this->connection->exec(
        "CREATE TABLE IF NOT EXISTS user_groups (
            user_id INTEGER NOT NULL,
            group_id INTEGER NOT NULL,
            timestamp INTEGER NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users (id)
            FOREIGN KEY (group_id) REFERENCES groups (id)
        );"
    );
}

}
// group : id, name, user_id
 