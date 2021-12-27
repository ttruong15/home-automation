<?php

namespace Core\Http\Response;

use Core\Http\Response\Card\Image;
use Exception;

class Card implements Output
{
	private static array $types = ['Simple', 'Standard', 'LinkAccount', 'AskForPermissionsConsent'];
	private string $type;
	private ?string $title;
	private ?string $content;
	private ?string $text;
	private ?Image $image;

	public function __construct(string $type, ?string $title = null, ?string $content = null, ?string $text = null, Image $image = null)
	{
		$this->validateTypes($type);

		$this->type = $type;
		$this->title = $title;
		$this->content = $content;
		$this->text = $text;
		$this->image = $image;
	}

	/**
	 * Validte output card types
	 *
	 * @param string $type
	 * @return void
	 * @throw Exception
	 */
	public function validateTypes(string $type): void
	{
		if(!in_array($type, self::$types)) {
			throw new Exception('invalidSpeechType');
		}
	}

	/**
	 * Build an array structure for card response output
	 *
	 * return mixed
	 */
	public function output(): mixed
	{
		$output = [
			'type' => $this->type,
			'title' => $this->title,
			'content' => $this->content,
			'text' => $this->text,
			'image' => $this->image instanceof Image ? $this->image->toArray() : null,
		];

		return $output;
	}

	/**
	 * Serialize to json string for the output array
	 *
	 * @return string
	 */
	public function jsonSerialize(): string
	{
		return json_encode($this->output());
	}
}
