<?php


namespace Game;

const DIRECTION_UP = 'up';
const DIRECTION_DOWN = 'down';
const DIRECTION_RIGHT = 'right';
const DIRECTION_LEFT = 'left';

const AVAILABLE_DIRECTIONS = [
    DIRECTION_UP => [DIRECTION_UP, DIRECTION_LEFT, DIRECTION_RIGHT],
    DIRECTION_DOWN => [DIRECTION_DOWN, DIRECTION_LEFT, DIRECTION_RIGHT],
    DIRECTION_LEFT => [DIRECTION_DOWN, DIRECTION_LEFT, DIRECTION_UP],
    DIRECTION_RIGHT => [DIRECTION_DOWN, DIRECTION_RIGHT, DIRECTION_UP],
    null => [DIRECTION_DOWN, DIRECTION_RIGHT, DIRECTION_LEFT, DIRECTION_UP],
];

/**
 * @property Bonus[] bonuses
 * @property string direction
 * @property array lines
 * @property array position [x,y]
 * @property array territory
 * @property int score
 * @property int speed
 */
class Player
{
    function __construct($params)
    {
        $this->score = $params['score'];
        $this->territory = $params['territory'];
        $this->position = $params['position'];
        $this->lines = $params['lines'];
        $this->direction = $params['direction'];
        $this->bonuses = [];
        foreach ($params['bonuses'] as $bonus) {
            $this->bonuses[] = new Bonus($bonus);
        }
        $this->speed = 1;
    }

}
