<?php

namespace Skills\Intent;

abstract class Intent
{
	public function action(array $slots): void
	{
		foreach ($slots as $slot) {
			$slotNameCamelCase = $this->wordToCamelCase($slot->name);
			if(method_exists($this, $slotNameCamelCase)) {
				$value = $slot->value ?? null;
				$this->{$slotNameCamelCase}($value);
			}	
		}
	}

	private function wordToCamelCase(string $text): string
	{
		$camelCase = lcfirst(str_replace(' ', '', ucwords(str_replace(['_', '-'], ' ', $text))));

		return $camelCase;
	}
}
