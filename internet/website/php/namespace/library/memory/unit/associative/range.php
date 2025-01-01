<?php
	namespace library\memory\unit\associative;
?>

<?php
	class range {
		private ?array $value;
		private int $count;

		function __construct(?array $value) {
			$this->value = $value;
			if (isset($this->value) && array_is_list($this->value)) {
				$this->count = count($this->value, COUNT_NORMAL);
			}
		}

		public function value(): ?array {
			return $this->value;
		}

		public function count(): int {
			return $this->count;
		}
	}

	class dictionary {
		function __construct() { }
	}
?>