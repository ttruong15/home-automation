<?php

namespace Core\Http\Response;

use Exception;

class Directives implements Output
{
	private array $directives = [];

	public function __construct(array $directives = [])
	{
		$this->directives = $directives;
	}

	/**
	 * Build an array of Directive structure
	 *
	 * @return mixed
	 */
	public function output(): mixed
	{
		$content = [];
		foreach($this->directives as $directive) {
			if($directive instanceof Directive && $directive) {
				$content[] = $directive->output();
			}
		}

		return $content;
	}

	/**
	 * Serialize a Directives array to a json string
	 *
	 * @return string
	 */
	public function jsonSerialize(): string
	{
		return json_encode($this->output());
	}
}
