<?php

namespace Core\Http\Response;

use Exception;

class ShouldEndSession implements Output
{
	private bool $shouldEndSession;

	public function __construct(bool $shouldEndSession = false)
	{
		$this->shouldEndSession = $shouldEndSession;
	}

	/**
	 * Return the value of shouldEndSession
	 *
	 * @return mixed
	 */
	public function output(): mixed
	{
		return $this->shouldEndSession;
	}

	/**
	 * Return the value of shouldEndSession
	 *
	 * @return string
	 */
	public function jsonSerialize(): string
	{
		return json_encode($this->output());
	}
}
