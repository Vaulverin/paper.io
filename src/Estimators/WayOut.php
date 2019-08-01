<?php


namespace Estimators;


use SplQueue;

class WayOut extends AbstractEstimator
{

    function estimate($direction, $weight)
    {
        $hero = $this->tick->hero;
        $nextPosition = $this->getNextPosition($direction, $hero->position);
        $startNode = $this->positionToString($nextPosition);
        $endNodes = $this->mapToArrayOfStrings($hero->territory);
        $graph = $this->makeGraph($hero->lines);
        if (!$this->bfs($graph, $startNode, $endNodes)) {
            return -1;
        }

        return $weight;
    }

    /*
 * A simple iterative Breadth-First Search implementation.
 * http://en.wikipedia.org/wiki/Breadth-first_search
 *
 * 1. Start with a node, enqueue it and mark it visited.
 * 2. Do this while there are nodes on the queue:
 *     a. dequeue next node.
 *     b. if it's what we want, return true!
 *     c. search neighbours, if they haven't been visited,
 *        add them to the queue and mark them visited.
 *  3. If we haven't found our node, return false.
 *
 * @returns bool
 */
    protected function bfs($graph, $start, $end)
    {
        $queue = new SplQueue();
        $queue->enqueue($start);
        $visited = [$start];
        while ($queue->count() > 0) {
            $node = $queue->dequeue();
            # We've found what we want
            if (in_array($node, $end)) {
                return true;
            }
            if (isset($graph[$node])) {
                foreach ($graph[$node] as $neighbour) {
                    if (!in_array($neighbour, $visited)) {
                        # Mark neighbour visited
                        $visited[] = $neighbour;
                        # Enqueue node
                        $queue->enqueue($neighbour);
                    }
                }
            }
        }
        return false;
    }

    protected function makeGraph($exception)
    {
        $strException = $this->mapToArrayOfStrings($exception);
        $graph = [];
        $step = $this->settings->width;
        $start = $this->settings->width / 2;
        $end = $this->settings->xCount * $this->settings->width - $start;
        for($x = $start; $x <= $end; $x += $step) {
            for($y = $start; $y <= $end; $y += $step) {
                $node = $this->positionToString([$x, $y]);
                $neighbors = [
                    [$x + $step, $y],
                    [$x - $step, $y],
                    [$x, $y - $step],
                    [$x, $y + $step],
                ];

                foreach ($neighbors as $neighbor) {
                    $isExist = true;
                    foreach ($neighbor as $value) {
                        if ($value < 0 || $value > $end) {
                            $isExist = false;
                        }
                    }
                    $strNeighbor = $this->positionToString($neighbor);
                    if ($isExist && !in_array($strNeighbor, $strException)) {
                        $graph[$node][] = $strNeighbor;
                    } else {
                        $a = 1;
                    }
                }
            }
        }

        return $graph;
    }

    protected function positionToString($position)
    {
        return sprintf('[%1$s, %2$s]', $position[0], $position[1]);
    }

    protected function mapToArrayOfStrings($map)
    {
        $result = [];
        foreach ($map as $position) {
            $result[] = $this->positionToString($position);
        }

        return $result;
    }


}
