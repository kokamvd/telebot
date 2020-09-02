<?php

namespace WeStacks\TeleBot\Objects\Stickers;

use WeStacks\TeleBot\TelegramObject;

/**
 * This object describes the position on faces where a mask should be placed by default.
 * 
 * @property String               $point                The part of the face relative to which the mask should be placed. One of “forehead”, “eyes”, “mouth”, or “chin”.
 * @property Float                $x_shift              Shift by X-axis measured in widths of the mask scaled to the face size, from left to right. For example, choosing -1.0 will place mask just to the left of the default mask position.
 * @property Float                $y_shift              Shift by Y-axis measured in heights of the mask scaled to the face size, from top to bottom. For example, 1.0 will place the mask just below the default mask position.
 * @property Float                $scale                Mask scaling coefficient. For example, 2.0 means double size.
 * 
 * @package WeStacks\TeleBot\Objects\Stickers
 */
class MaskPosition extends TelegramObject
{
    protected function relations()
    {
        return [
            'point'         => 'string',
            'x_shift'       => 'float',
            'y_shift'       => 'float',
            'scale'         => 'float'
        ];
    }
}