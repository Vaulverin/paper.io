<?php


namespace Estimators;


use Helpers\BFSCached;
use Helpers\BreadthFirstSearch;

/**
 * Чем больше территори захватим - тем лучше!
 * Определяем по дистанции от захваченных территорий, если точка дальше всех - она приоритет.
 * Class Greedy
 * @package Estimators
 */
class GreedyWayEstimator extends AbstractEstimator
{

    function estimate($direction, $weight)
    {
        $hero = $this->tick->hero;
        $nextPosition = $this->getNextPosition($direction, $hero->position);
        if (count($hero->lines) == 0) {
            $map = $this->getCells($hero->territory);
            $distances = [];
            foreach ($map as $position) {
                $distances[] = getDistanceBtwPositions($nextPosition, $position);
            }
            if (count($distances) > 0) {
                sort($distances);
                if ($distances[0] > 0) {
                    $weight /= $distances[0];
                }
            }
        } else {
            $map = array_slice($hero->lines, -4, 3);
            foreach ($map as $position) {
                $weight += getDistanceBtwPositions($nextPosition, $position);
            }
            $bfs = new BreadthFirstSearch($this->settings->width, $this->settings->xCount);
            $bfs = new BFSCached($bfs);
            $path = $bfs->getShortestPath($nextPosition, $hero->territory, $hero->lines);
            $distance = count($path) / $hero->speed;

            if ($distance / count($hero->lines) < 0.3) {
                foreach ($hero->territory as $position) {
                    $weight += getDistanceBtwPositions($nextPosition, $position) / $distance;
                }
            }
        }

        return $weight;
    }

    protected function getCells($except)
    {
        $cells = [];
        $step = $this->settings->width;
        $start = $this->settings->width / 2;
        $end = $this->settings->xCount * $this->settings->xCount - $start;
        for($x = $start; $x <= $end; $x += $step) {
            for ($y = $start; $y <= $end; $y += $step) {
                $position = [$x, $y];
                if (!isPositionInMap($position, $except)) {
                    $cells[] = $position;
                }
            }
        }

        return $cells;
    }

}
