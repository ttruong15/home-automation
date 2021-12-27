<?php

namespace Core\Http\Response;

use Exception;

class OutputSpeech implements Output
{
	private static array $types = ['PlainText', 'SSML'];
	private static array $playBehaviors = ['ENQUEUE', 'REPLACE_ALL', 'REPLACE_ENQUEUED'];
	private string $type;
	private string $text;

	public function __construct(string $type = 'PlainText', string $text = 'OK', string $playBehavior = 'ENQUEUE')
	{
		if(!in_array($playBehavior, self::$playBehaviors)) {
			throw new Exception('invalidPlayBehavior');
		}

		$this->type = $type;
		$this->text = $text;
		$this->playBehavior = $playBehavior;
	}

	/**
	 * Validate the type provided to ensure only supported type are accepted
	 *
	 * @params string $type
	 * @return void
	 * @throw Exception
	 */
	public function validateType(string $type): void
	{
		if(!in_array($type, self::$types)) {
			throw new Exception('invalidSpeechType');
		}
	}

	/**
	 * Build an array structure for OutputSpeech
	 *
	 * @return mixed
	 */
	public function output(): mixed
	{
		$output = [
			'type' => $this->type,
			'text' => $this->text,
			'playBehavior' => $this->playBehavior,
		];

		return $output;
	}

	/**
	 * Serialize an output array to a json string
	 *
	 * @return string
	 */
	public function jsonSerialize(): string
	{
		return json_encode($this->output());
	}
}
