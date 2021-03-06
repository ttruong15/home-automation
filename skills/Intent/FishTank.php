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
			$outputSpeech = new OutputSpeech('PlainText', 'Feeding the fish');
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

			$outputSpeech = new OutputSpeech('PlainText', "Feeding the fish $value time" . ($value > 1 ? 's' : ''));
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
			shell_exec(MOSQ_PUB_COMMAND . ' -h ' . MOSQ_HOST . ' -p ' . MOSQ_PORT . ' -t ' . LIGHT_TOPIC . ' -m "' . $ucValue . '"');
			$outputSpeech = new OutputSpeech('PlainText', "Turning the light $value");
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
		shell_exec(MOSQ_PUB_COMMAND . ' -h ' . MOSQ_HOST . ' -p ' . MOSQ_PORT . ' -t ' . FEED_FISH_TOPIC . ' -m "ON"');
	}
}
