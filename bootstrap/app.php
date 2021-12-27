<?php

if(!file_exists('../.env')) {
	throw new Exception('Missing .env');
}
require_once('../.env');

$app = new Core\Application();

return $app;
