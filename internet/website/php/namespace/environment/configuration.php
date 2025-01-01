<?php
	namespace environment\configuration;
?>

<?php
	class data {
		private string $filePath;
		private ?array $value;

		function __construct(?string $filePath = null) {
			$this->filePath = isset($filePath) ? $filePath : "internet/website/php/environment/configuration/iceKnives32.json";
			if (file_exists($this->filePath)) {
				$j = file_get_contents($this->filePath);
				if (isset($j)) {
					$d = json_decode($j, true); 
					if (isset($d)) {
						$this->value = $d;
					}
				}
			}
		}

		public function filePath(): string {
			return $this->filePath;
		}

		public function value(): ?array {
			return $this->value;
		}
	}
?>