<?php

namespace Core\Http\Response;

use Exception;

class Reprompt implements Output
{
	private OutputSpeech $outputSpeech;

	public function __construct(OutputSpeech $outputSpeech)
	{
		$this->outputSpeech = $outputSpeech;
	}

	/**
	 * Build an output array structure for Reprompt
	 *
	 * @return mixed
	 */
	public function output(): mixed
	{
		$output = [
			'outputspeech' => $this->outputSpeech->toArray(),
		];

		return $output;
	}

	/**
	 * Serialize the ouput array to a json string
	 *
	 * @return string
	 */
	public function jsonSerialize(): string
	{
		return json_encode($this->output());
	}
}
