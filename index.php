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
	/*
	*/
	$letterCodes = [
		"a" => 3, "b" => 2, "c" => 3, "d" => 3, "e" => 3, "f" => 5, "g" => 3, "h" => 4, "i" => 3, "j" => 5, "k" => 5, "l" => 7, "m" => 5, "n" => 5, "o" => 5, "p" => 5, "q" => 4, "r" => 4, "s" => 5, "t" => 3, "u" => 5, "v" => 2, "w" => 7, "x" => 1, "y" => 6, "z" => 6,
		"A" => 3, "B" => 2, "C" => 3, "D" => 3, "E" => 3, "F" => 5, "G" => 3, "H" => 4, "I" => 3, "J" => 5, "K" => 5, "L" => 7, "M" => 5, "N" => 5, "O" => 5, "P" => 5, "Q" => 4, "R" => 4, "S" => 5, "T" => 3, "U" => 5, "V" => 2, "W" => 7, "X" => 1, "Y" => 6, "Z" => 6
	];

	/*
	*/
	$raw = file("32.txt");

	/*
	*/
	$filter = [];
	$i = 0;
	foreach ($raw as $key) {
		$filter[$i++] = trim($key);
	}

	/*
	*/
	$position = 1;
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
			"position_numeric" => $position++,
			"character_length" => strlen($key),
			"noncharacter_count" => $noncharacterCount,
			"check_key" => $checkKey
		];
	}

	/*
	*/
	$grid = [];
	for ($i = 0; $i <= 25; $i++) {
		for ($j = 0; $j <= 25; $j++) {
			$grid[$i][$j] = $filter[($j * 26) + $i];
		}
	}

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
?>

<?php
	/*
	*/
	echo "<table>";
	echo "<tr><td>x</td>";
	for ($k = 1; $k <= 26; $k++) {
		echo "<td>" . $k . "</td>";
	}
	echo "<td>sum</td></tr>";
	$i = 1;
	foreach ($grid as $row) {
		$sum = 0;
		echo "<tr>";
		echo "<td>" . $i++ . "</td>";
		foreach ($row as $column) {
			echo "<td>";
			echo '<span class="key">' . $column . '</span><br>';
			echo '<span class="positionNumeric">' . $data[$column]["position_numeric"] . "</span>" . '<span class="characterLength">' . $data[$column]["character_length"] . '</span>';
			echo '<span tooltip="' . getFactorsOfNumber($data[$column]["check_key"]) . '"><span class="checkKey">' . $data[$column]["check_key"] . '</span></span>';
			echo "</td>";
			$sum += $data[$column]["check_key"];
		}
		echo '<td><span tooltip="' . getFactorsOfNumber($sum) . '" flow="left">' . $sum . '</td>';
		echo "</tr>";
	}
	echo "</table>";
?>

	</body>
</html>