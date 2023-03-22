<?php

namespace Core;

class Database
{
	private $adaptor;

	public function __construct($adaptor, $hostname, $username, $password, $database, $port = NULL)
	{
		$class = __NAMESPACE__ . "\\Database\\" . $adaptor;

		if (class_exists($class)) {
			$this->adaptor = new $class($hostname, $username, $password, $database, $port);
		} else {
			throw new \Exception('Error: Could not load database adaptor ' . $adaptor . '!');
		}
	}

	public function query(string $sql): array
	{
		return $this->adaptor->query($sql);
	}

	public function escape($value): string
	{
		return $this->adaptor->escape($value);
	}

	public function countAffected(): int
	{
		return $this->adaptor->countAffected();
	}

	public function getLastId(): int
	{
		return $this->adaptor->getLastId();
	}

	public function connected(): bool
	{
		return $this->adaptor->connected();
	}
}
