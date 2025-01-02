<?php
	namespace library\memory\unit\associative;
?>

<?php
	class range {
		private ?array $value;
		private int $count;

		function __construct(?array $value = null) {
			$this->value = null;
			$this->count = 0;
			if (isset($value)) {
				$i = 0;
				foreach ($value as $v) {
					if (is_array($v) || is_object($v)) {
						$this->value = null;
						break;
					}
					else {
						$this->value[$i++] = $v;
					}
				}
				$this->count = isset($this->value) ? count($this->value, COUNT_NORMAL) : $this->count;
			}
		}

		public function value(): ?array {
			return $this->value;
		}

		public function count(): int {
			return $this->count;
		}

		public function firstValue(): mixed {
			return isset($this->value) && $this->count > 0 ? $this->value[0] : null;
		}

		public function lastValue(): int {
			return $this->count;
		}
	}

	class dictionary {
		function __construct() { }
	}
?>