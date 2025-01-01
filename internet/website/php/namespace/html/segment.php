<?php
	namespace html\segment;
?>

<?php
	class website {
		private string $title;
		private string $charset;
		private array $css;
		private array $js;
		private string $timeZone;

		function __construct(?string $title = null, ?string $charset = null, ?array $css = null, ?array $js = null, ?string $timeZone = null) {
			$this->title = isset($title) ? $title : "iceKnives32";
			$this->charset = isset($charset) ? $charset : "utf-8";
			$this->css = isset($css) && count($css) > 0 ? $css : ["internet/website/css/style.css"];
			$this->js = isset($js) && count($js) > 0 ? $js : [];
			$this->timeZone = isset($timeZone) ? $timeZone : "Asia/Kolkata";
			$this->configureTimeZone();
		}

		private function configureTimeZone(): void {
			date_default_timezone_set($this->timeZone);
		}

		public function head(): string {
			$result = "";
			$result = '<!DOCTYPE html>
						<html lang="en">
							<head>
								<title>' . $this->title . '</title>
								<meta charset="' . $this->charset . '">
								<meta name="viewport" content="width=device-width, initial-scale=1">';
			foreach ($this->css as $v) {
				$result .= '<link rel="stylesheet" href="' . $v .'">';
			}
			foreach ($this->js as $v) {
				$result .= '<script src="' . $v .'"></script>';
			}
			$result .= '</head><body>';
			return $result;
		}

		public function foot(): string {
			$result = "";
			$result = "</body></html>";
			return $result;
		}

		public function time(): string {
			$date = date("Y/m/d h:i:s a", time());
			return $date;
		}
	}
?>