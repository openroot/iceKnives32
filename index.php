<?php
	require_once("internet/website/php/namespace/module/type/english/alphabet.php");
	require_once("internet/website/php/namespace/environment/configuration.php");
	require_once("internet/website/php/namespace/application/segment.php");

	//use application\segment as applicationSegment;
?>

<?php
	$webpageConfiguration = null;
	$environmentConfiguration = new environment\configuration\data();
	if (isset($environmentConfiguration) && isset($environmentConfiguration->value()["internet"]["website"]["php"]["namespace"]["application"]["segment"]["webpage"])) {
		$webpageConfiguration = $environmentConfiguration->value()["internet"]["website"]["php"]["namespace"]["application"]["segment"]["webpage"];
	}
	if (!keysExistsInArray($webpageConfiguration, ["title", "charset", "meta", "css", "js", "timeZone"])) {
		$webpageConfiguration = null;
	}
	if (!isset($webpageConfiguration)) {
		$webpageConfiguration = [
			"title" => "iceKnives32",
			"charset" => "utf-8",
			"meta" => ['name="viewport" content="width=device-width, initial-scale=1"'],
			"css" => ["internet/website/css/iceKnives32/style.css"],
			"js" => [],
			"timeZone" => "Asia/Kolkata"
		];
	}
	
	$webpage = new application\segment\webpage($webpageConfiguration["title"], $webpageConfiguration["charset"], $webpageConfiguration["meta"], $webpageConfiguration["css"], $webpageConfiguration["js"], $webpageConfiguration["timeZone"]);
	echo $webpage->head();
?>

<?php
	/* x. Context */
	$alphabetCode = module\type\english\alphabet::code;

	$fileName = isset($_REQUEST["f"]) ? $_REQUEST["f"] : "f.x";
	$rowCount = isset($_REQUEST["f"]) ? (int)$_REQUEST["r"] : 28;
	$columnCount = isset($_REQUEST["f"]) ? (int)$_REQUEST["c"] : 6;
	$fileNameInitial = explode(".", $fileName)[0];
	$fileNameExtension = explode(".", $fileName)[1];

	/* 1. Raw */
	$raw = file("set/chain/" . $fileName . "/" . $fileName);

	/* 2. Filter */
	$filter = [];
	$i = 0;
	foreach ($raw as $key) {
		$filter[$i++] = trim($key);
	}

	/* 3. Data */
	$data = [];
	foreach ($filter as $key) {
		$noncharacterCount = 0;
		$checkKey = 0;
		$characters = str_split($key);
		foreach ($characters as $character) {
			if (!array_key_exists($character, $alphabetCode)) {
				$noncharacterCount++;
			}
			else {
				$checkKey += $alphabetCode[$character];
			}
		}
		$data[$key] = [
			"character_length" => strlen($key),
			"noncharacter_count" => $noncharacterCount,
			"check_key" => $checkKey
		];
	}

	/* 4. Grid */
	$grid = [];
	for ($i = 0; $i < $rowCount; $i++) {
		for ($j = 0; $j < $columnCount; $j++) {
			$grid[$i][$j] = $filter[($j * $rowCount) + $i];
		}
	}

	/* 5. Information */
	$information = [];
	$information["top"] = $grid[0];
	$information["bottom"] = $grid[$rowCount - 1];
	$information["value"] = array_slice($grid, 1, $rowCount - 2);

	/* 6. Paragraph */
	$t = count($information["value"]);
	$paragraph = [];
	foreach ($information as $k => $set) {
		if ($k === "value") {
			foreach ($information["value"] as $i => $row) {
				foreach ($row as $j => $column) {
					$paragraph[$k][$i][$j] = [
						"text" => $information["value"][$i][$j],
						"numeric_position" => ($j * $t) + $i + 1
					];
				}
			}
		}
		else {
			foreach ($set as $i => $v) {
				$paragraph[$k][$i] = [
					"text" => $information[$k][$i]
				];
			}
		}
	}

	/* 7. Socket */
	$socket = [];
	$socket[0][0]["text"] = "{_" . $fileNameInitial . "}";
	for ($i = 1; $i <= $columnCount; $i++) {
		$socket[0][$i]["text"] = "{" . $i . "}";
	}
	$socket[0][$columnCount + 1]["text"] = "{" . "_s" . "}";
	$socket[1][0]["text"] = "{_" . $fileNameExtension . "}";
	$socket[1] = array_merge($socket[1], $paragraph["top"]);
	$s = 0;
	foreach ($paragraph["top"] as $v) {
		$s += $data[$v["text"]]["check_key"];
	}
	$socket[1][$columnCount + 1]["sum"] = $s;
	for ($i = 1; $i < $rowCount - 1; $i++) {
		$socket[$i + 1][0]["text"] = "{" . $i . "}";
		$socket[$i + 1] = array_merge($socket[$i + 1], $paragraph["value"][$i - 1]);
		$s = 0;
		foreach ($paragraph["value"][$i - 1] as $v) {
			$s += $data[$v["text"]]["check_key"];
		}
		$socket[$i + 1][$columnCount + 1]["sum"] = $s;
	}
	$socket[$rowCount][0]["text"] = "{" . "_@" . "}";
	$socket[$rowCount] = array_merge($socket[$rowCount], $paragraph["bottom"]);
	$s = 0;
	foreach ($paragraph["bottom"] as $v) {
		$s += $data[$v["text"]]["check_key"];
	}
	$socket[$rowCount][$columnCount + 1]["sum"] = $s;
	$socket[$rowCount + 1][0]["text"] = "{_s}";
	$p = 1;
	for ($i = 0; $i < $columnCount; $i++) {
		$s = 0;
		for ($j = 0; $j < $rowCount - 2; $j++) {
			$s += $data[$paragraph["value"][$j][$i]["text"]]["check_key"];
		}
		$socket[$rowCount + 1][$p++]["sum"] = $s;
	}
	$s = 0;
	for ($i = 2; $i <= $rowCount - 1; $i++) {
		$s += $socket[$i][$columnCount + 1]["sum"];
	}
	$socket[$rowCount + 1][$p]["sum"] = $s;
	$socket[$rowCount + 2][0]["text"] = "{_t}";
	for ($i = 1; $i <= $columnCount; $i++) {
		$socket[$rowCount + 2][$i]["sum"] = $socket[$rowCount + 1][$i]["sum"] + $data[$paragraph["top"][$i - 1]["text"]]["check_key"];
	}
	$socket[$rowCount + 2][$columnCount + 1]["sum"] = $socket[$rowCount + 1][$columnCount + 1]["sum"] + $socket[1][$columnCount + 1]["sum"];
	$socket[$rowCount + 3][0]["text"] = "{_#}";
	for ($i = 1; $i <= $columnCount; $i++) {
		$socket[$rowCount + 3][$i]["sum"] = $data[$socket[1][$i]["text"]]["check_key"] + $data[$socket[$rowCount][$i]["text"]]["check_key"];
	}
	$socket[$rowCount + 3][$columnCount + 1]["sum"] = $socket[1][$columnCount + 1]["sum"] + $socket[$rowCount][$columnCount + 1]["sum"];

	/**/
	function factorsOfNumber(int $number): string {
		$result = "";
		if ($number > 0) {
			$factor;
			for ($factor = 2; $factor < $number; $factor++) {
				if ($number % $factor == 0) {
					$result .= $factor . ", ";
				}
			}
			if (strlen($result) > 0) {
				$result = substr($result, 0, -2);
			}
		}
		return $result;
	}

	function keysExistsInArray(array $hash, array $needle): bool {
		$result = true;
		foreach ($needle as $v) {
			if (!array_key_exists($v, $hash)) {
				$result = false;
				break;
			}
		}
		return $result;
	}

	/*echo "<pre>";
	print_r($socket);
	echo "</pre>";*/
?>

<?php
	echo "<table>";
	foreach ($socket as $i => $row) {
		echo "<tr>";
		foreach ($row as $j => $column) {
			echo "<td>";
			if (array_key_exists("text", $column)) {
				echo '<span class="key">' . $column["text"] . '</span>';
			}
			if (array_key_exists("sum", $column)) {
				$f = $j > $columnCount ? "left" : "up"; 
				echo '<span tooltip="' . factorsOfNumber($column["sum"]) . '" flow="' . $f . '">{' . $column["sum"] . '}';
			}
			if (array_key_exists("numeric_position", $column)) {
				echo "<br>";
				echo '<span class="numericPosition">' . $column["numeric_position"] . "</span>" . '<span class="characterLength">' . $data[$column["text"]]["character_length"] . '</span>';
				echo '<span tooltip="' . factorsOfNumber($data[$column["text"]]["check_key"]) . '"><span class="checkKey">' . $data[$column["text"]]["check_key"] . '</span></span>';
			}
			else if (($i === 1 || $i === $rowCount) && isset($column["text"]) && isset($data[$column["text"]]["check_key"])) {
				echo "<br>";
				echo '<span class="characterLength">' . $data[$column["text"]]["character_length"] . '</span>';
				echo '<span tooltip="' . factorsOfNumber($data[$column["text"]]["check_key"]) . '"><span class="checkKey">' . $data[$column["text"]]["check_key"] . '</span></span>';
			}
			echo "</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
?>

<?php
	echo $webpage->foot();
?>