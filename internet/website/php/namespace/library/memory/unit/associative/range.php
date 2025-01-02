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

		public function first(): mixed {
			return isset($this->value) && $this->count > 0 ? $this->value[0] : null;
		}

		public function last(): mixed {
			return isset($this->value) && $this->count > 0 ? $this->value[$this->count - 1] : null;
		}

		public function add(mixed $data, ?int $position = null): bool {
			$result = false;
			if (is_array($data) || is_object($data)) {
				return false;
			}
			else {
				if (!isset($position)) {
					$this->value[$this->count++] = $data;
					$result = true;
				}
				else if ($position <= $this->count + 1) {
					/*$c = 0;
					$t = $this->value;
					$this->value = [];
					for ($i = 0; $i < $this->count + 1; $i++) {
						if ($i === $position - 1) {
							$this->value[$c] = $data;
						}
						$this->value[$c] = $t[$c];
						$c++;
					}
					$result = true;*/
				}
			}
			return $result;
		}
	}

	class dictionary {
		function __construct() { }
	}
?>