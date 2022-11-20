<?php
return [

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'container' => [
        'definitions' => [
            \yii\widgets\LinkPager::class => \yii\bootstrap4\LinkPager::class,
            'yii\bootstrap4\LinkPager' => [
                'firstPageLabel' => 'First',
                'lastPageLabel'  => 'Last'
            ]
        ],
    ],
    'components' => [
        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'RUB',
            'datetimeFormat' => 'php: d-m-Y',
            'nullDisplay' => ''
        ],
        'cache' => [
            'class' => 'yii\caching\MemCache',
            'useMemcached'  => true,
        ],
    ],
];
