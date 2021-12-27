<?php

namespace Core\Http\Response;

use Exception;

interface Output
{
	/**
	 * Format the response output for an Output type
	 *
	 * @return mixed
	 */
	public function output(): mixed;

	/**
	 * Serialize the output array to a json string
	 *
	 * @return string
	 */
	public function jsonSerialize(): string;
}
