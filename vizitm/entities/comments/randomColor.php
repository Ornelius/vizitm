<?php


namespace vizitm\entities\comments;


class randomColor
{
    static function randColor(): string
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

}