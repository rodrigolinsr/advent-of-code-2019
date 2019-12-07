<?php
[$lowerLimit, $upperLimit] = array_map(function (string $value) {
    return intval($value);
}, explode('-', trim(file_get_contents('./inputs/day4.txt'))));

$validPasswords = [];
for ($password = $lowerLimit; $password <= $upperLimit; $password++) {
    $passwordString = (string) $password;

    $hasTwoAdjacents        = false;
    $numbersDecrease        = false;
    $allRepeatedAreLargerGroup = false;

    for ($i = 0; $i < strlen($passwordString); $i++) {
        if ($passwordString[$i] === ($passwordString[$i+1] ?? null)) {
            $hasTwoAdjacents = true;
        }

        if (isset($passwordString[$i+1]) && intval($passwordString[$i+1]) < intval($passwordString[$i])) {
            $numbersDecrease = true;
        }
    }

    if ($hasTwoAdjacents) {
        $repeatedGroups = [];
        for ($i = 0; $i < strlen($passwordString); $i++) {
            $repeatedGroup  = "";
            if ($passwordString[$i] === ($passwordString[$i + 1] ?? null)) {
                $currentNumber = $passwordString[$i];
                $repeatedGroup .= $currentNumber;
                for ($j = $i + 1; isset($passwordString[$j]) && $passwordString[$j] === $currentNumber; $j++) {
                    $repeatedGroup .= $passwordString[$j];
                }
                $i = $j-1;

                $repeatedGroups[] = $repeatedGroup;
            }
        }

        $allRepeatedAreLargerGroup = true;
        foreach ($repeatedGroups as $repeatedGroup) {
            if (strlen($repeatedGroup) === 2) {
                $allRepeatedAreLargerGroup = false;
                break;
            }
        }
    }

    if ($hasTwoAdjacents && !$numbersDecrease && !$allRepeatedAreLargerGroup) {
        $validPasswords[] = $password;
    }
}

$sample = $validPasswords;
shuffle($sample);
var_dump('Here are some examples of valid passwords:');
var_dump(implode(', ', array_slice($sample, 0, 10)));
var_dump('Total of different passwords: ' . count($validPasswords));