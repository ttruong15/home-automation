<?php

namespace Core\Http\Response\Directive\Metadata;

class Source
{
	private string $url;

	public function __construct(string $url, ?string $size = null, ?int $widthPixels = null, ?int $heightPixels = null)
	{
		$this->url = $url;
		$this->size = $size;
		$this->widthPixels = $widthPixels;
		$this->heightPixels = $heightPixels;
	}

	/**
	 * Build an array structure for Source
	 *
	 * @return array
	 */
	public function toArray(): array
	{
		return [
			'url' => $this->url,
			'size' => $this->size,
			'widthPixels' => $this->widthPixels,
			'heightPixels' => $this->heightPixels,
		];
	}

	/**
	 * Serialize a Source array to a json string
	 *
	 * @return string
	 */
	public function jsonSerialize(): string
	{
		return json_encode($this->toArray());
	}
}
