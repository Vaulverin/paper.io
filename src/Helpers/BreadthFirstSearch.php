<?php
namespace Helpers;

use SplQueue;

class BreadthFirstSearch
{

    /**
     * @var int
     */
    private $cellWidth;
    /**
     * @var int
     */
    private $cellsCount;

    function __construct(int $cellWidth, int $cellsCount)
    {
        $this->cellWidth = $cellWidth;
        $this->cellsCount = $cellsCount;
    }

    function isReachable(array $startPosition, array $destinationPositions, array $exceptPosition)
    {
        return $this->getShortestPath($startPosition, $destinationPositions, $exceptPosition) !== false;
    }

    function getShortestPath(array $startPosition, array $destinationPositions, array $exceptPosition)
    {
        list($startNode, $endNodes, $graph) = [
            $this->positionToString($startPosition),
            $this->mapToArrayOfStrings($destinationPositions),
            $this->makeGraph($exceptPosition),
        ];
        $graph = $this->bfs_path($graph, $startNode, $endNodes);

        return $this->stringsToPositions($graph);
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
 * Same as bfs() except instead of returning a bool, it returns a path.
 *
 * Implemented by enqueuing a path, instead of a node, for each neighbour.
 *
 * @returns array or false
 */
    protected function bfs_path($graph, $start, $end) {
        $queue = new SplQueue();
        # Enqueue the path
        $queue->enqueue([$start]);
        $visited = [$start];
        while ($queue->count() > 0) {
            $path = $queue->dequeue();
            # Get the last node on the path
            # so we can check if we're at the end
            $node = $path[sizeof($path) - 1];

            if (in_array($node, $end)) {
                return $path;
            }
            if (isset($graph[$node])) {
                foreach ($graph[$node] as $neighbour) {
                    if (!in_array($neighbour, $visited)) {
                        $visited[] = $neighbour;
                        # Build new path appending the neighbour then and enqueue it
                        $new_path = $path;
                        $new_path[] = $neighbour;
                        $queue->enqueue($new_path);
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
        $step = $this->cellWidth;
        $start = $this->cellWidth / 2;
        $end = $this->cellsCount * $this->cellWidth - $start;
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
                    }
                }
            }
        }

        return $graph;
    }

    protected function positionToString($position)
    {
        return sprintf('[%1$s,%2$s]', $position[0], $position[1]);
    }

    protected function mapToArrayOfStrings($map)
    {
        $result = [];
        foreach ($map as $position) {
            $result[] = $this->positionToString($position);
        }

        return $result;
    }

    protected function stringsToPositions($graph)
    {
        if($graph === false) {
            return $graph;
        }
        $result = [];
        foreach ($graph as $strPosition) {
            $result[] = explode(',', trim($strPosition, '[]'));
        }

        return $result;
    }
}
