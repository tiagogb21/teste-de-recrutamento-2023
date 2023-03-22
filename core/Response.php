<?php

namespace Core;

class Response
{
	private $headers = [], $output;

	public function addHeader($header)
	{
		$this->headers[] = $header;
	}

	public function redirect($url, $status = 302)
	{
		header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url), true, $status);
		exit();
	}

	public function getOutput()
	{
		return $this->output;
	}

	public function setOutput($output)
	{
		$this->output = $output;
	}

	public function output()
	{
		if (!$this->output)
			return;

		if (!headers_sent()) {
			foreach ($this->headers as $header) {
				header($header, true);
			}
		}

		echo $this->output;
	}
}
