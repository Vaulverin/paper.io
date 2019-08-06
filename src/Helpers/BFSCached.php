<?php


namespace Helpers;


class BFSCached extends BreadthFirstSearch
{
    /**
     * @var BreadthFirstSearch
     */
    private $bfs;
    private static $results = [];

    function __construct(BreadthFirstSearch $bfs)
    {
        $this->bfs = $bfs;
    }

    function getShortestPath(array $startPosition, array $destinationPositions, array $exceptPosition)
    {
        $key = sha1(serialize([$startPosition, $destinationPositions, $exceptPosition]));
        if (!isset(static::$results[$key])) {
            static::$results[$key] = $this->bfs->getShortestPath($startPosition, $destinationPositions, $exceptPosition);
        }

        return static::$results[$key];
    }

}
