<?php
namespace Game;

/**
 * @property int xCount
 * @property int yCount
 * @property int speed
 * @property int width
 * @property int maxTickCount
 */
class Settings
{
    function __construct(array $settings)
    {
        $this->xCount = $settings['x_cells_count'];
        $this->yCount = $settings['y_cells_count'];
        $this->speed = $settings['speed'] / 5;
        $this->width = $settings['width'];
        $this->maxTickCount = 1490;
    }

}
