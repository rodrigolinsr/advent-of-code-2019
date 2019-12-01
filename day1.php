<?php
$modules = file('./inputs/day1.txt');

function calc($module)
{
    return floor(($module / 3)) - 2;
}

function calcAllStages($module) {
    $moduleFuel = 0;

    do {
        $module = calc($module);
        $moduleFuel += $module;
    } while (calc($module) > 0);

    return $moduleFuel;
}

var_dump(calcAllStages(12));
var_dump(calcAllStages(14));
var_dump(calcAllStages(1969));
var_dump(calcAllStages(100756));

$total = 0;
foreach ($modules as $module) {
    $module     = intval(trim($module));
    $moduleFuel = calcAllStages($module);

    $total += $moduleFuel;
}

var_dump($total);
