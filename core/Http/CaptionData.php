<?php

namespace Core\Http;

class CaptionData 
{
	private ?string $content = null;

	public function __construct(?string $content = null)
	{
		$this->content = $content;
	}

	public function toArray(): array
	{
		return [
			'content' => $this->content,
		];
	}

	public function jsonSerialize(): string
	{
		return json_encode($this->toArray());
	}
}
