<?php

namespace Core\Http\Response\Directive;

class CaptionData 
{
	private ?string $content = null;

	public function __construct(?string $content = null)
	{
		$this->content = $content;
	}

	/**
	 * Build an array structure for CaptionData
	 *
	 * @return array
	 */
	public function toArray(): array
	{
		return [
			'content' => $this->content,
		];
	}

	/**
	 * Serialize the output CaptionData to a json string
	 *
	 * @return string
	 */
	public function jsonSerialize(): string
	{
		return json_encode($this->toArray());
	}
}
