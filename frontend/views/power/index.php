<?php
use yii\helpers\Url;
use dosamigos\chartjs\ChartJs;

/* @var $this yii\web\View */

$this->title = 'Потребление ресурсов Калужская 11';
?>
<?php
$gas= ChartJs::widget([
    'type' => 'bar',
    'options' => [
        'height' => 160,
        'width'  => 900
    ],
    'data' => [
        'labels' => ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль"],
        'datasets' => [
            [
                'label' => "Природный газ",
                'backgroundColor' => "rgba(224, 235, 16, 1)",
                'borderColor' => "rgba(179,181,198,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#FC0",
                'pointHoverBackgroundColor' => "#FC0",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => [65, 59, 90, 81, 56, 55, 40]
            ],
        ]
    ]
]);

$woter= ChartJs::widget([
    'type' => 'bar',
    'options' => [
        'height' => 160,
        'width'  => 900
    ],
    'data' => [
        'labels' => ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль"],
        'datasets' => [
            [
                'label' => "Холодная вода",
                'backgroundColor' => "rgba(16, 173, 235, 1)",
                'borderColor' => "rgba(255,99,132,1)",
                'pointBackgroundColor' => "rgba(255,99,132,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(255,99,132,1)",
                'data' => [28, 48, 40, 19, 96, 27, 100]
            ],
        ]
    ]
]);

$electr= ChartJs::widget([
    'type' => 'bar',
    'options' => [
        'height' => 160,
        'width'  => 900
    ],
    'data' => [
        'labels' => ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль"],
        'datasets' => [
            [
                'label' => "Электроэнергия",
                'backgroundColor' => "rgba(64, 235, 16, 1)",
                'borderColor' => "rgba(255,99,132,1)",
                'pointBackgroundColor' => "rgba(255,99,132,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(255,99,132,1)",
                'data' => [28, 48, 40, 19, 96, 27, 100]
            ]
        ]
    ]
]);


?>

<div class="content">
    <div class="row">
        <div class="content-flex">
            <?php \insolita\wgadminlte\CollapseBox::begin([
                'type'=>\insolita\wgadminlte\LteConst::TYPE_WARNING,
                'collapseRemember' => true,
                'collapseDefault' => false,
                'isSolid'=>true,
                'tooltip'=>'Описание содаржимого',
                'title'=>'Природный газ',
            ])?>
            <?= $gas?>
            <?php \insolita\wgadminlte\CollapseBox::end()?>
        </div>
    </div>

    <div class="row">
        <div class="content-flex">
            <?php \insolita\wgadminlte\CollapseBox::begin([
                'type'=>\insolita\wgadminlte\LteConst::TYPE_INFO,
                'collapseRemember' => true,
                'collapseDefault' => false,
                'isSolid'=>true,
                'tooltip'=>'Описание содаржимого',
                'title'=>'Холодная вода',
            ])?>
            <?= $woter ?>
            <?php \insolita\wgadminlte\CollapseBox::end()?>
        </div>
    </div>

    <div class="row">
        <div class="content-flex">
            <?php \insolita\wgadminlte\CollapseBox::begin([
                'type'=>\insolita\wgadminlte\LteConst::TYPE_SUCCESS,
                'collapseRemember' => true,
                'collapseDefault' => false,
                'isSolid'=>true,
                'tooltip'=>'Описание содаржимого',
                'title'=>'Електроэнергия',
            ])?>
            <?= $electr ?>
            <?php \insolita\wgadminlte\CollapseBox::end()?>
        </div>
    </div>


</div>









        <div class="body-content">


        </div>
    </div>
</div>

