<?php

declare(strict_types=1);

namespace App\Clients;

use PDO;

class Mysql
{
    private const DEFAULT_HOST = 'database';
    private const DEFAULT_PORT = '3306';
    private const DEFAULT_USERNAME = 'root';
    private const DEFAULT_PASSWORD = 'root';
    private const DEFAULT_DATABASE = 'test';

    private $pdo;

    public function __construct(
        private readonly string $host = self::DEFAULT_HOST,
        private readonly string $port = self::DEFAULT_PORT,
        private readonly string $username = self::DEFAULT_USERNAME,
        private readonly string $password = self::DEFAULT_PASSWORD,
        private readonly string $database = self::DEFAULT_DATABASE,
    ) {
        $this->pdo = new PDO(
            "mysql:host={$this->host};port={$this->port};dbname={$this->database}",
            $this->username,
            $this->password,
        );
    }

    public function query(string $sql): array
    {
        $stmt = $this->pdo->query($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
