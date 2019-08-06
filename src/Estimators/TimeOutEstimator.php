<?php


namespace Estimators;


use Helpers\BFSCached;
use Helpers\BreadthFirstSearch;

/**
 * Если скоро конец матча, то самые короткие пути до своей территории приоритетнее.
 * Class TimeOut
 * @package Estimators
 */
class TimeOutEstimator extends AbstractEstimator
{

    function estimate($direction, $weight)
    {
        $hero = $this->tick->hero;
        $nextPosition = $this->getNextPosition($direction, $hero->position);
        $bfs = new BreadthFirstSearch($this->settings->width, $this->settings->xCount);
        $bfs = new BFSCached($bfs);
        $path = $bfs->getShortestPath($nextPosition, $hero->territory, $hero->lines);
        $lastTicks = $this->settings->maxTickCount - $this->tick->tickNum;
        $distance = count($path) / $hero->speed;
        if ($lastTicks <= $distance) {
            return $weight / $distance;
        }

        return $weight;
    }
    
}
