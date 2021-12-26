<?php

namespace Core\Http;

use Exception;

class Request {

	private static $content;

	public static function init(): void {
		self::$content = json_decode(file_get_contents("php://input"));

		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new Exception("Error: " . json_last_error_msg(), json_last_error());
		}

		self::validate();
	}

	public static function validate(): void
	{
		if(defined('ALLOW_ALL_APPLICATION') && ALLOW_ALL_APPLICATION) {
			return;
		}

		if(defined("APPLICATION_IDS")) {
			$session = self::getSession();
			if(!$session) {
				throw new Exception('sessionExpired');
			}

			if(!in_array($session->application->applicationId, APPLICATION_IDS)) {
				throw new Exception('InvalidApplicationId');
			}
		}
	}

	public static function getRequest(): ?object {
		return self::$content->request ?? null;
	}

	public static function getSession(): object {
		return self::$content->session ?? null;
	}

	public static function getIntentName(): ?string
	{
		return self::$content->request->intent->name ?? null;
	}

	public static function getIntentSlots(): array
	{
		return self::$content->request->intent->slots ?? [];
	}
}
