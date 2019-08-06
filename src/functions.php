<?php

function getDistanceBtwPositions(array $positionA, array $positionB)
{
    return sqrt(pow($positionA[0] - $positionB[0], 2) + pow($positionA[1] - $positionB[1], 2));
}

function isPositionInMap($position, $map)
{
    foreach ($map as $mapPosition) {
        if ($position[0] == $mapPosition[0] && $position[1] == $mapPosition[1]) {
            return true;
        }
    }

    return false;
}
