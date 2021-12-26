<?php

namespace Core;

use Core\Http\Request;
use Exception;
use Skills\Intent;

class Application {

	public function start(): void 
	{
		try {
			Request::init();
			$intentRequest = Request::getRequest();
			$this->parseIntent($intentRequest->intent);

			$this->response();
		} catch(Exception $e) {
			$this->failed();
		}
	}

	private function parseIntent($intent): void
	{
		$intentName = '\Skills\Intent\\' . $intent->name;
		if (class_exists($intentName)) {
			$intentObj = new $intentName;
			$intentObj->action((array) $intent->slots);
		} else {
			throw new Exception("IntentNotDefine");
		}

	}

	private function response(): void
	{
		$response = [
			"version" => "1.0",
			"response" => [
				"outputSpeech" => [
					"type" => "PlainText",
					"text" => "OK",
				],
			],
		];

		$content = json_encode($response);
		header("HTTP/1.1 200 OK");
		header("Content-Type: application/json;charset=UTF-8");
		header("Content-Length: " . strlen($content));

		echo $content;
	}
	
	private function failed(): void
	{
		$response = [
			"version" => "1.0",
			"response" => [
				"text" => "Welcome, work in progress",
			],
		];

		$content = json_encode($response);
		header("HTTP/1.1 200 OK");
		header("Content-Type: application/json;charset=UTF-8");
		header("Content-Length: " . strlen($content));

		echo $content;
	}
}
