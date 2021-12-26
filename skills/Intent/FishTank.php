<?php

namespace Skills\Intent;

class FishTank extends Intent
{

	/**
	 * Feed the fish once
	 *
	 * @param string $value
	 * @return void
	 */
	public function feed(?string $value = null): void
	{
		if ($value === 'feed') {
			$this->feedFish();
		}
	}

	/**
	 * Feed the fish multiple times
	 *
	 * @param int $value
	 * @return void
	 */
	public function recurrence(?int $value = null): void
	{
		for($i = 0; $i < $value; $i++) {
			$this->feedFish();
			sleep(2);
		}
	}

	public function lightAction(?string $value = null): void
	{
		$ucValue = strtoupper($value);
		if (in_array($ucValue, ['ON', 'OFF'])) {
			if ($ucValue === 'OFF') {
				$ucValue = 'ON';
			} else {
				$ucValue = 'OFF';
			}
			shell_exec('/usr/bin/mosquitto_pub -h 192.168.1.10 -t home/fishtank/light -m "' . $ucValue . '"');
		}
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
