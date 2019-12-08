<?php
function calc(array &$inputsArray)
{
    for ($i = 0; isset($inputsArray[($i + 4)]); $i += 4) {
        $opcode = intval($inputsArray[$i]);

        if ($opcode === 99 || !in_array($opcode, [1,2])) {
            break;
        }

        $index1      = $inputsArray[$i+1];
        $index2      = $inputsArray[$i+2];
        $indexTarget = $inputsArray[$i+3];

        $value1 = $inputsArray[$index1];
        $value2 = $inputsArray[$index2];

        if ($opcode === 1) {
            $inputsArray[$indexTarget] = $value1 + $value2;
        }

        if ($opcode === 2) {
            $inputsArray[$indexTarget] = $value1 * $value2;
        }
    }
}

$example = [1,0,0,0,99];
calc($example);
var_dump($example);

$example = [2,3,0,3,99];
calc($example);
var_dump($example);

$example = [2,4,4,5,99,0];
calc($example);
var_dump($example);

$example = [1,1,1,4,99,5,6,0,99];
calc($example);
var_dump($example);

$inputs = trim(file_get_contents('./inputs/day2.txt'));

$inputsArray = explode(',', $inputs);
$inputsArray[1] = 12;
$inputsArray[2] = 2;

calc($inputsArray);

var_dump($inputsArray[0]);
