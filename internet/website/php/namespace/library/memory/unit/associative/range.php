<?php
	namespace library\memory\unit\associative;
?>

<?php
	class range {
		private ?array $source;
		private int $count;

		function __construct(?array $source = null) {
			$this->source = null;
			$this->count = 0;
			if (isset($source)) {
				$i = 0;
				foreach ($source as $s) {
					if (is_array($s) || is_object($s)) {
						$this->source = null;
						break;
					}
					else {
						$this->source[$i++] = $s;
					}
				}
				$this->count = isset($this->source) ? count($this->source, COUNT_NORMAL) : $this->count;
			}
		}

		public function __get($name): mixed {
			switch($name) {
				case "source":
					return $this->source;
					break;
				case "count":
					return $this->count;
					break;
			}
		}

		public function first(): mixed {
			return isset($this->source) && $this->count > 0 ? $this->source[0] : null;
		}

		public function last(): mixed {
			return isset($this->source) && $this->count > 0 ? $this->source[$this->count - 1] : null;
		}

		public function update(): bool {
			$result = false;
			return $result;
		}

		public function add(mixed $data, ?int $position = null): bool {
			$result = false;
			if (is_array($data) || is_object($data)) {
				return false;
			}
			else {
				if (!isset($position)) {
					$this->source[$this->count++] = $data;
					$result = true;
				}
				else if ($position > 0 && $position <= $this->count + 1) {
					$c = 0;
					$t = $this->source;
					$this->source = [];
					if ($position === $this->count + 1) {
						$t[$this->count + 1] = $data;
						$this->source = $t;
					}
					else {
						for ($i = 0; $i < $this->count; $i++) {
							if ($i === $position - 1) {
								$this->source[$c++] = $data;
							}
							$this->source[$c++] = $t[$i];
						}
					}
					$this->count++;
					$result = true;
				}
			}
			return $result;
		}

		public function find(): bool {
			$result = false;
			return $result;
		}

		public function delete(): bool {
			$result = false;
			return $result;
		}

		public function chunk(): bool {
			$result = false;
			return $result;
		}

		public function part(): bool {
			$result = false;
			return $result;
		}

		public function sort(): bool {
			$result = false;
			return $result;
		}

		public function reset(): bool {
			$result = false;
			return $result;
		}

		public function modified(): bool {
			$result = false;
			return $result;
		}

		public function truncate(): bool {
			$result = false;
			return $result;
		}
	}
?>