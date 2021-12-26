<?php
#error_reporting(E_ALL);
#ini_set("display_errors", 1);
$contents = file_get_contents("php://input");
file_put_contents("/tmp/headers.txt", $_SERVER, FILE_APPEND);
file_put_contents("/tmp/hello.txt", $contents, FILE_APPEND);

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
