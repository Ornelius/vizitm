<?php


namespace vizitm\services\request;


use dynamikaweb\lightgallery\LightGallery;

class LightingGalleryEXP extends LightGallery
{

    public function renderItem($item, $tag, $itemsOptions = null): string
    {
        return str_replace('data-src','"data-video"',parent::renderItem($item, $tag, $itemsOptions));
    }
}