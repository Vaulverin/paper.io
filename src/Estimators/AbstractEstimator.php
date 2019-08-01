<?php
namespace Estimators;

use Game\Settings;
use Game\Tick;
use const Game\DIRECTION_DOWN;
use const Game\DIRECTION_LEFT;
use const Game\DIRECTION_RIGHT;
use const Game\DIRECTION_UP;

abstract class AbstractEstimator
{
    /**
     * @var Settings
     */
    protected $settings;
    /**
     * @var Tick
     */
    protected $tick;

    function __construct(Settings $settings, Tick $tick)
    {
        $this->settings = $settings;
        $this->tick = $tick;
    }

    abstract function estimate($direction, $weight);

    function getNextPosition($direction, $currentPosition)
    {
        $nextPosition = $currentPosition;
        $distanceToGo = $this->settings->width * $this->settings->speed;
        switch ($direction) {
            case DIRECTION_UP:
                $nextPosition[1] += $distanceToGo;
                break;
            case DIRECTION_DOWN:
                $nextPosition[1] -= $distanceToGo;
                break;
            case DIRECTION_LEFT:
                $nextPosition[0] -= $distanceToGo;
                break;
            case DIRECTION_RIGHT:
                $nextPosition[0] += $distanceToGo;
                break;
        }

        return $nextPosition;
    }

}
