<?php

namespace Core\Http\Response;

use Core\Http\Response\Output;
use Exception;

class Response {

	private static ?string $content;
	private static ?Response $self = null;
	private array $response = [];

	private function __construct(?string $content = null)
	{
		self::$content = $content;
	}

	/**
	 * Only instantiate this object if it have not yet instantiated.
	 *
	 * @params string|null $content
	 * @return self
	 */
	public static function new(?string $content = null): self
	{
		if(self::$self) {
			return self::$self;
		}

		self::$self = new Response($content);

		return self::$self;
	}

	/**
	 * Append response for an Output type response, only one response type will be added
	 *
	 * @params Output $response
	 * @return void
	 */
	public function addResponse(Output $response): void
	{
		$classNames = explode('\\', get_class($response));
		$className = array_pop($classNames);
		$responseType = lcfirst($className);

		if(!array_key_exists($responseType, $this->response)) {
			$this->response[$responseType] = $response;
		}
	}

	/**
	 * Get response content
	 *
	 * @return array
	 */
	public static function getContent(): array
	{
		return self::$content;
	}

	/**
	 * Set response content
	 *
	 * @params string $content
	 * @return void
	 */
	public static function setConent(string $content): void
	{
		self::$content = $content;
	}

	/**
	 * Output the response content including headers
	 * @params int $code
	 * @return void
	 */
	public function output(int $code = 200): void
	{
		$content = $this->outputContent();
		$this->headerOutput($code, $content);
	}

	/**
	 * Output an error response including headers
	 *
	 * @params int $code
	 * @params string|null $message
	 * @return null
	 */
	public function error(int $code = 500, ?string $message = null): void
	{
		$this->response = [];
		$this->response['text'] = $message ?? 'Error';

		$this->output($code);
	}

	/**
	 * Build the output header body response as a json string
	 *
	 * @return string
	 */
	public function outputContent(): string
	{
                $response = [
                        "version" => AWS_VERSION,
		];

		foreach($this->response as $responseType => $responseObj) {
			$response['response'][$responseType] = $responseObj instanceof Output ? $responseObj->output() : $responseObj;
		}

                return json_encode($response);
	}

	/**
	 * Output http headers and body content
	 *
	 * @params int $code
	 * @prams string $content
	 * @return void
	 */
	public function headerOutput(int $code, string $content): void
	{
                header("HTTP/1.1 $code OK");
                header("Content-Type: application/json;charset=UTF-8");
                header("Content-Length: " . strlen($content));

                echo $content;
	}
}
