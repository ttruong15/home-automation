<?php

namespace Core\Http\Response\Directive;

use Core\Http\Response\Directive\Metadata\Image;

class Metadata 
{
	private string $title;
	private string $subTitle;
	private ?Image $art = null;
	private ?Image $backgroundImage = null;

	public function __construct(?string $title = null, ?string $subTitle = null, ?Image $art = null, Image $backgroundImage = null)
	{
		$this->title = $title;
		$this->subTitle = $subTitle;
		$this->art = $art;
		$this->backgroundImage = $backgroundImage;
	}

	/**
	 * Build an array structure for MetaData
	 *
	 * @return array
	 */
	public function toArray(): array
	{
		return [
			'title' => $this->title,
			'subTitle' => $this->subTitle,
			'art' => $this->art instanceof Image ? $this->art->toArray() : null,
			'backgroundImage' => $this->backgroundImage instanceof Image ? $this->backgroundImage->toArray() : null,
		];
	}

	/**
	 * Serialize Metadata array structure to a json string
	 *
	 * @return string
	 */
	public function jsonSerialize(): string
	{
		return json_encode($this->toArray());
	}
}
