<?php

namespace Core\Http\Response;

use Core\Http\Response\Directive\AudioItem;
use Exception;

class Directive implements Output
{
	private static array $types = ['AudioPlayer.Play', 'AudioPlayer.Stop', 'AudioPlayer.ClearQueue'];
	private string $type;
	private string $playerBehavior;
	private ?AudioItem $audioItem;

	public function __construct(string $type, string $playerBehavior, ?AudioItem $audioItem = null)
	{
		$this->validateType($type);

		$this->type = $type;
		$this->playerBehavior = $playerBehavior;
		$this->audioItem = $audioItem;
	}

	public function validateType(string $type): void
	{
		if(!in_array($type, self::$types)) {
			throw new Exception('invalidType');
		}
	}

	public function output(): mixed
	{
		$output = [
			'type' => $this->type,
			'playerBehavior' => $this->playerBehavior,
			'audioItem' => $this->audioItem instanceof AudioItem ? $this->audioItem->toArray() : null,
		];

		return $output;
	}

	public function jsonSerialize(): string
	{
		return json_encode($this->output());
	}
}
