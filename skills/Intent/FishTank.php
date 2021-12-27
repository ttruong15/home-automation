<?php

namespace Skills\Intent;

use Core\Http\Response\Output;
use Core\Http\Response\OutputSpeech;

class FishTank extends Intent
{

	/**
	 * Feed the fish once
	 *
	 * @param string $value
	 * @return Output|null
	 */
	public function feed(?string $value = null): ?Output
	{
		$outputSpeech = null;
		if ($value === 'feed') {
			$this->feedFish();
			$outputSpeech = new OutputSpeech('PlainText', 'Feed fish');
		}

		return $outputSpeech;
	}

	/**
	 * Feed the fish multiple times
	 *
	 * @param int $value
	 * @return Output|null
	 */
	public function recurrence(?int $value = null): ?Output
	{
		$outputSpeech = null;
		if($value > 0) {
			for($i = 0; $i < $value; $i++) {
				$this->feedFish();
				sleep(2);
			}

			$outputSpeech = new OutputSpeech('PlainText', "Feed fish $value time" . ($value > 1 ? 's' : ''));
		}

		return $outputSpeech;
	}

	/**
	 * Turn on/off light action
	 *
	 * @param string|null $value
	 * @return Output|null
	 */
	public function lightAction(?string $value = null): ?Output
	{
		$outputSpeech = null;
		$ucValue = strtoupper($value);
		if (in_array($ucValue, ['ON', 'OFF'])) {
			if ($ucValue === 'OFF') {
				$ucValue = 'ON';
			} else {
				$ucValue = 'OFF';
			}
			shell_exec('/usr/bin/mosquitto_pub -h 192.168.1.10 -t home/fishtank/light -m "' . $ucValue . '"');
			$outputSpeech = new OutputSpeech('PlainText', "Turn light $value");
		}

		return $outputSpeech;
	}

	/**
	 * Execute the queue service to feed the fish
	 *
	 * @return void
	 */
	private function feedFish(): void
	{
		shell_exec('/usr/bin/mosquitto_pub -h 192.168.1.10 -t home/fishtank/feedfish -m "ON"');
	}
}
