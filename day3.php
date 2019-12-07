<?php
$inputs = file('./inputs/day3.txt');
$inputsWire1 = explode(',', trim($inputs[0]));
$inputsWire2 = explode(',', trim($inputs[1]));

function processWire(array $inputsWire, array &$matrixWire, array &$matrixStepsWire)
{
    $i = 0;
    $j = 0;
    $totalSteps = 0;
    foreach ($inputsWire as $item) {
        $direction = substr($item, 0, 1);
        $steps     = intval(substr($item, 1));

        for($count = 0; $count < $steps; $count++) {
            if ($direction === 'R') {
                $matrixWire[++$i][$j] = '-';
            } else if ($direction === 'L') {
                $matrixWire[--$i][$j] = '-';
            } if ($direction === 'U') {
                $matrixWire[$i][++$j] = '-';
            } if ($direction === 'D') {
                $matrixWire[$i][--$j] = '-';
            }

            $totalSteps++;
            if (!isset($matrixStepsWire[$i][$j])) {
                $matrixStepsWire[$i][$j] = $totalSteps;
            }
        }
    }
}

function getMinDistanceAndSteps(array $matrixWire1, array $matrixStepsWire1, array $matrixWire2, array $matrixStepsWire2)
{
    $minDistance = -1;
    $minSteps    = -1;
    foreach ($matrixWire1 as $idxI => $valuesI) {
        foreach ($valuesI as $idxJ => $valueJ) {
            if (isset($matrixWire2[$idxI][$idxJ])) {
                $sumDistance = abs($idxI) + abs($idxJ);
                if ($minDistance === -1 || $sumDistance < $minDistance) {
                    $minDistance = $sumDistance;
                }

                $sumSteps = $matrixStepsWire1[$idxI][$idxJ] + $matrixStepsWire2[$idxI][$idxJ];
                if ($minSteps === -1 || $sumSteps < $minSteps) {
                    $minSteps = $sumSteps;
                }
            }
        }
    }

    return [
        'distance' => $minDistance === -1 ? 0 : $minDistance,
        'steps'    => $minSteps === -1 ? 0 : $minSteps,
    ];
}

$matrixWire1      = [];
$matrixStepsWire1 = [];
$matrixWire2      = [];
$matrixStepsWire2 = [];

processWire($inputsWire1, $matrixWire1, $matrixStepsWire1);
processWire($inputsWire2, $matrixWire2, $matrixStepsWire2);

var_dump(getMinDistanceAndSteps($matrixWire1, $matrixStepsWire1, $matrixWire2, $matrixStepsWire2));