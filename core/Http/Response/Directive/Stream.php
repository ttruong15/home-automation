<?php

namespace Core\Http\Response\Directive;

class Stream 
{
	private string $url;
	private string $token;
	private string $expectedPreviousToken;
	private int $offsetInMilliseconds;
	private ?CaptionData $captionData = null;

	public function __construct(string $url, string $token, string $expectedPreviousToken, int $offsetInMilliseconds, ?CaptionData $captionData = null)
	{
		$this->url = $url;
		$this->token = $token;
		$this->expectedPreviousToken = $expectedPreviousToken;
		$this->offsetInMilliseconds = $offsetInMilliseconds;
		$this->captionData = $captionData;
	}

	/**
	 * Build an array structure for Stream
	 *
	 * @return array
	 */
	public function toArray(): array
	{
		return [
			'url' => $this->url,
			'token' => $this->token,
			'expectedPreviousToken' => $this->expectedPreviousToken,
			'offsetInMilliseconds' => $this->offsetInMilliseconds,
			'captionData' => $this->captionData instanceof CaptionData ? $this->captionData->toArray() : null,
		];
	}

	/**
	 * Serialize a Stream array structure to a json string
	 *
	 * @return string
	 */
	public function jsonSerialize(): string
	{
		return json_encode($this->toArray());
	}
}
