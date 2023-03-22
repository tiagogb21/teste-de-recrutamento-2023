<?php

namespace Core\Database;

interface IAdapter
{
	public function query(string $sql): array;
	public function escape($value): string;
	public function countAffected(): int;
	public function getLastId(): int;
	public function connected(): bool;
}
