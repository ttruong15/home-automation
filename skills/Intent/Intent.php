<?php

namespace Skills\Intent;

use Core\Http\Response\Output;

abstract class Intent
{
	/**
	 * Loop through all slots and use the slot name to check if a method is define for it.
	 * If defined call that method
	 *
	 * @param array $slots
	 * @return array
	 */
	public function action(array $slots): array
	{
		$output = [];
		foreach ($slots as $slot) {
			$slotNameCamelCase = $this->wordToCamelCase($slot->name);
			if(method_exists($this, $slotNameCamelCase)) {
				$value = $slot->value ?? null;
				$output[] = $this->{$slotNameCamelCase}($value);
			}	
		}

		return $output;
	}

	/**
	 * Convert a string to camelcase
	 *
	 * @params string $text
	 * @return string
	 */
	private function wordToCamelCase(string $text): string
	{
		$camelCase = lcfirst(str_replace(' ', '', ucwords(str_replace(['_', '-'], ' ', $text))));

		return $camelCase;
	}
}
