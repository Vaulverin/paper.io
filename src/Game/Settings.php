<?php
namespace Game;

/**
 * @property int xCount
 * @property int yCount
 * @property int speed
 * @property int width
 */
class Settings
{
    function __construct(array $settings)
    {
        $this->xCount = $settings['x_cells_count'];
        $this->yCount = $settings['y_cells_count'];
        $this->speed = $settings['speed'];
        $this->width = $settings['width'];
    }

}
