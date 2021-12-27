<?php

namespace Core\Http\Response\Directive;

class AudioItem 
{
	private Stream $stream;
	private Metadata $metadata;

	public function __construct(Stream $stream, Metadata $metadata)
	{
		$this->stream = $stream;
		$this->metadata = $metadata;
	}

	/**
	 * Build an array structure for AudioItem
	 *
	 * @return array
	 */
	public function toArray(): array
	{
		return [
			'stream' => $this->stream->toArray(),
			'metadata' => $this->metadata->toArray(),
		];
	}

	/**
	 * Serialize an array output to a json string
	 *
	 * @return string
	 */
	public function jsonSerialize(): string
	{
		return json_encode($this->toArray());
	}
}
