<?php

namespace Core\Http\Response\Card;

class Image 
{
	private ?string $smallImageUrl = null;
	private ?string $largeImageUrl = null;

	public function __construct(?string $smallImageUrl = null, ?string $largeImageUrl = null)
	{
		$this->smallImageUrl = $smallImageUrl;
		$this->largeImageUrl = $largeImageUrl;
	}

	/**
	 * Build an array data structure for Image response content
	 *
	 * @return array
	 */
	public function toArray(): array
	{
		$content = [];

		if($this->smallImageUrl) {	
			$content['smallImageUrl'] = $this->smallImageUrl;
		}
		if($this->largeImageUrl) {	
			$content['largeImageUrl'] = $this->largeImageUrl;
		}

		return $content;
	}

	/**
	 * Serialize the array of Image output to a json string
	 *
	 * @return string
	 */
	public function jsonSerialize(): string
	{
		return json_encode($this->toArray());
	}
}
