<?php

namespace Core\Database;

class PDO implements IAdapter
{
	private $pdo;
	private $queryResponse;

	public function __construct($hostname, $username, $password, $database, $port = NULL)
	{
		$dsn = "mysql:host=$hostname;dbname=$database;charset=UTF8;port=$port";

		try {
			$this->pdo = new \PDO($dsn, $username, $password);
		} catch (\PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function query(string $sql): array
	{
		$this->queryResponse = $this->pdo->query($sql, \PDO::FETCH_ASSOC);

		return $this->queryResponse->fetchAll();
	}

	public function escape($value): string
	{
		return $this->pdo->quote($value);
	}

	public function countAffected(): int
	{
		return $this->queryResponse->fetchColumn();
	}

	public function getLastId(): int
	{
		return $this->pdo->lastInsertId();
	}

	public function connected(): bool
	{
		return !empty($this->pdo);
	}
}
