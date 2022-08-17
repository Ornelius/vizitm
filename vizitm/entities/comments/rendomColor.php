<?php


namespace vizitm\entities\comments;


class rendomColor
{
    static function randColor(): string
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

}