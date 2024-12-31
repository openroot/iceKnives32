<!DOCTYPE html>
<html lang="en">
	<head>
		<title>iceKnives32</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="style.css">
		<script src=""></script>
	</head>
	<body>

<?php
	/* x. Context */
	$letterCodes = [
		"a" => 3, "b" => 2, "c" => 3, "d" => 3, "e" => 3, "f" => 5, "g" => 3, "h" => 4, "i" => 3, "j" => 5, "k" => 5, "l" => 7, "m" => 5, "n" => 5, "o" => 5, "p" => 5, "q" => 4, "r" => 4, "s" => 5, "t" => 3, "u" => 5, "v" => 2, "w" => 7, "x" => 1, "y" => 6, "z" => 6,
		"A" => 3, "B" => 2, "C" => 3, "D" => 3, "E" => 3, "F" => 5, "G" => 3, "H" => 4, "I" => 3, "J" => 5, "K" => 5, "L" => 7, "M" => 5, "N" => 5, "O" => 5, "P" => 5, "Q" => 4, "R" => 4, "S" => 5, "T" => 3, "U" => 5, "V" => 2, "W" => 7, "X" => 1, "Y" => 6, "Z" => 6
	];

	$fileName = isset($_REQUEST["f"]) ? $_REQUEST["f"] : "f.x";
	$rowCount = isset($_REQUEST["f"]) ? $_REQUEST["r"] : 28;
	$columnCount = isset($_REQUEST["f"]) ? $_REQUEST["c"] : 6;
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
			if (!array_key_exists($character, $letterCodes)) {
				$noncharacterCount++;
			}
			else {
				$checkKey += $letterCodes[$character];
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
	$s1 = 0;
	foreach ($paragraph["value"] as $i => $row) {
		$s = 0;
		foreach ($row as $j => $column) {

		}
	}
	$socket[$rowCount + 2][0]["text"] = "{_t}";
	$socket[$rowCount + 3][0]["text"] = "{_#}";

	/**/
	function getFactorsOfNumber(int $number) {
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

	//echo "<pre>";
	//print_r($socket);
	//echo "</pre>";
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
				echo '<span tooltip="' . getFactorsOfNumber($column["sum"]) . '" flow="left">{' . $column["sum"] . '}';
			}
			if (array_key_exists("numeric_position", $column)) {
				echo "<br>";
				echo '<span class="numericPosition">' . $column["numeric_position"] . "</span>" . '<span class="characterLength">' . $data[$column["text"]]["character_length"] . '</span>';
				echo '<span tooltip="' . getFactorsOfNumber($data[$column["text"]]["check_key"]) . '"><span class="checkKey">' . $data[$column["text"]]["check_key"] . '</span></span>';
			}
			echo "</td>";
		}
		echo "</tr>";
	}	
	echo "</table>";
?>

	</body>
</html>