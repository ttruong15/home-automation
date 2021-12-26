<?php

if(file_exists("../.env")) {
	require_once("../.env");
}

$app = new Core\Application();

return $app;
