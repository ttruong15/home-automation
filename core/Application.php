<?php

namespace Core;

use Core\Http\Request\Request;
use Core\Http\Response\Card;
use Core\Http\Response\Card\Image as CardImage;
use Core\Http\Response\Directive;
use Core\Http\Response\Directive\AudioItem;
use Core\Http\Response\Directive\CaptionData;
use Core\Http\Response\Directive\Metadata;
use Core\Http\Response\Directive\Metadata\Image;
use Core\Http\Response\Directive\Metadata\Source;
use Core\Http\Response\Directive\Stream;
use Core\Http\Response\Directives;
use Core\Http\Response\OutputSpeech;
use Core\Http\Response\ShouldEndSession;
use Core\Http\Response\Response;
use Exception;
use Skills\Intent;

class Application {

	public function start(): void 
	{
		$response = Response::new();
		try {
			Request::init();
			$intentRequest = Request::getRequest();
/*
			$response->addResponse(new OutputSpeech('PlainText', 'Hello world'));
			$response->addResponse(new Card('Simple', 'title', 'content', 'text', new CardImage('abc', 'def')));

			$sources = [new Source('url', 'size', 800, 1200)];
			$art = new Image('contentDescription', $sources);

			$backgroundSources = [new Source('url', 'size', 300, 400)];
			$backgroundImage = new Image('contentDescription', $backgroundSources);

			$metadata = new Metadata('title', 'subTitle', $art, $backgroundImage);
			$captionData = new CaptionData('content');
			$stream = new Stream('url', 'token', 'expectedPreviousToken', 1000, $captionData);
			$audioItem = new AudioItem($stream, $metadata);

			$directives[] = new Directive('AudioPlayer.Play', 'playerbehavoir', $audioItem);
			$directives[] = new Directive('AudioPlayer.Play', 'playerbehavoir');
			$response->addResponse(new Directives($directives));
			$response->addResponse(new ShouldEndSession());
*/
			$outputs = $this->parseIntent($intentRequest->intent);
			foreach($outputs as $output) {
				$response->addResponse($output);
			}

			$response->output();
		} catch(Exception $e) {
			$response->error(500, $e->getMessage());
		}
	}

	private function parseIntent($intent): array
	{
		$intentName = '\Skills\Intent\\' . $intent->name;
		if (class_exists($intentName)) {
			$intentObj = new $intentName;
			$response = $intentObj->action((array) $intent->slots);

			return $response;
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
