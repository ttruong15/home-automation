<?php
define('ALEXAPP_START', microtime(true));

error_reporting(E_ALL);
ini_set("display_errors", 1);

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->start();

exit;
$contents = file_get_contents("php://input");
file_put_contents("/tmp/headers.txt", $_SERVER, FILE_APPEND);
file_put_contents("/tmp/hello.txt", $contents, FILE_APPEND);

Core\Request::init();

$intentName = Core\Request::getRequest();

echo "ONE";
echo "\n";
print_r($intentName);
echo "\n";
exit;
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
