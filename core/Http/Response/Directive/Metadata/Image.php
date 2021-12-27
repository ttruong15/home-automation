<?php

namespace Core\Http\Response\Directive\Metadata;


class Image 
{
	private ?string $contentDescription = null;
	private ?array $sources = null;

	public function __construct(?string $contentDescription = null, ?array $sources = null)
	{
		$this->contentDescription = $contentDescription;
		$this->sources = $sources;
	}

	/**
	 * Build an array structure for Image
	 *
	 * @return array
	 */
	public function toArray(): array
	{
		$content = [];
		foreach($this->sources as $source) {
			if($source instanceof Source && $source) {
				$content[] = $source->toArray();
			}
		}

		return [
			'contentDescription' => $this->contentDescription,
			'sources' => $content,
		];


	}

	/**
	 * Serialize an Image array structure to a json string
	 *
	 * @return string
	 */
	public function jsonSerialize(): string
	{
		return json_encode($this->toArray());
	}
}
