<?php

namespace Core;

class Action
{
	private $id;
	private $classname;
	private $method = 'index';

	public function __construct($route)
	{
		$this->id = $route;

		$parts = explode('/', preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route));

		while ($parts) {
			$classname = "App\\Controllers\\" . implode("\\", $parts);

			if (class_exists($classname)) {
				$this->classname = $classname;

				break;
			} else {
				$this->method = array_pop($parts);
			}
		}
	}

	public function getId()
	{
		return $this->id;
	}

	public function execute($registry, array $args = array())
	{
		if (substr($this->method, 0, 2) == '__') {
			return new \Exception('Error: Calls to magic methods are not allowed!');
		}

		if (class_exists($this->classname))
			$controller = new $this->classname($registry);
		else
			return new \Exception('Error: Could not call ' . $this->classname . '/' . $this->method . '!');

		$reflection = new \ReflectionClass($this->classname);

		if ($reflection->hasMethod($this->method) && $reflection->getMethod($this->method)->getNumberOfRequiredParameters() <= count($args)) {
			return call_user_func_array(array($controller, $this->method), $args);
		} else {
			return new \Exception('Error: Could not call ' . $this->classname . '/' . $this->method . '!');
		}
	}
}
