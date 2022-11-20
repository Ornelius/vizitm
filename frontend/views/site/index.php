<?php
use yii\helpers\Url;
use dosamigos\chartjs\ChartJs;
use vizitm\entities\User;

/* @var $this yii\web\View */

$this->title = 'Потребление ресурсов ООО "Визит-М"';
?>
<?php
$content = ChartJs::widget([
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

$circleG = ChartJs::widget([
    'type' => 'pie',
    'id' => 'structurePie',
    'options' => [
        'height' => 400,
        'width' => 400,
    ],
    'data' => [
        'radius' =>  "90%",
        'labels' => ['Мичурина 148', 'Мичурина 150', 'Мичурина 152'], // Your labels
        'datasets' => [
            [
                'data' => ['35.6', '17.5', '46.9'], // Your dataset
                'label' => 'Газ',
                'backgroundColor' => [
                    '#ADC3FF',
                    '#FF9A9A',
                    'rgba(190, 124, 145, 0.8)'
                ],
                'borderColor' =>  [
                    '#fff',
                    '#fff',
                    '#fff'
                ],
                'borderWidth' => 1,
                'hoverBorderColor'=>["#999","#999","#999"],
            ]
        ]
    ],
    'clientOptions' => [
        'legend' => [
            'display' => false,
            'position' => 'bottom',
            'labels' => [
                'fontSize' => 14,
                'fontColor' => "#425062",
            ]
        ],
        'tooltips' => [
            'enabled' => true,
            'intersect' => true
        ],
        'hover' => [
            'mode' => true
        ],
        'maintainAspectRatio' => false,

    ],
]);


?>

<div class="content">
    <div class="row">
        <div class="content-flex">
            <?php \insolita\wgadminlte\CollapseBox::begin([
                'type'=>\insolita\wgadminlte\LteConst::TYPE_INFO,
                'collapseRemember' => true,
                'collapseDefault' => false,
                'isSolid'=>true,
                'tooltip'=>'Описание содаржимого',
                'title'=>'Ресурсы',
            ])?>
            <?= $content ?>
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
                'title'=>'Ресурсы',
            ])?>
            <div class="container">
                <div class="col-lg-4 col-xs-8">
kjkhjkhhjkjhjk
                </div>
                <div class="col-lg-4 col-xs-8">
                    <?= $circleG ?>
                </div>
            </div>







            <?php \insolita\wgadminlte\CollapseBox::end()?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <?php echo \insolita\wgadminlte\LteSmallBox::widget([
                'type'=>\insolita\wgadminlte\LteConst::COLOR_LIGHT_BLUE,
                'title'=>'Мичурина 138',
                'text'=> '<i class="fa fa-fire"> 90</i>&nbsp<i class="fa fa-tint"> 200</i>&nbsp<i class="fa fa-plug"> 4000</i>',
                'icon'=>'fa fa-bar-chart',
                'footer'=>'See All <i class="fa fa-hand-o-right"></i>',
                //'link'=>Url::to("/user/list")
            ]);?>

        </div>
        <div class="col-lg-3 col-xs-6">
            <?php echo \insolita\wgadminlte\LteSmallBox::widget([
                'type'=>\insolita\wgadminlte\LteConst::COLOR_TEAL,
                'title'=>'Калужская 11',
                'text'=>'<i class="fa fa-fire"> 90</i>&nbsp<i class="fa fa-tint"> 200</i>&nbsp<i class="fa fa-plug"> 4000</i>',
                'icon'=>'fa fa-bar-chart',
                'footer'=>'See All <i class="fa fa-hand-o-right"></i>',
                'link'=>Url::to("/power/index")
            ]);?>
        </div>
        <div class="col-lg-3 col-xs-6">
            <?php echo \insolita\wgadminlte\LteSmallBox::widget([
                'type'=>\insolita\wgadminlte\LteConst::COLOR_MAROON,
                'title'=>'Мичурина 150',
                'text'=>'<i class="fa fa-fire"> 90</i>&nbsp<i class="fa fa-tint"> 200</i>&nbsp<i class="fa fa-plug"> 4000</i>',
                'icon'=>'fa fa-bar-chart',
                'footer'=>'Посмотреть потребление ресурсов по дому <i class="fa fa-hand-o-right"></i>',
                'link'=>Url::to("/vizitm/users/")
            ]);?>
        </div>
        <div class="col-lg-3 col-xs-6">
            <?php echo \insolita\wgadminlte\LteSmallBox::widget([
                'type'=>\insolita\wgadminlte\LteConst::COLOR_PURPLE,
                'title'=>'Мичурина 152',
                'text'=>'<i class="fa fa-fire"> 90</i>&nbsp<i class="fa fa-tint"> 200</i>&nbsp<i class="fa fa-plug"> 4000</i>',
                'icon'=>'fa fa-bar-chart',
                'footer'=>'See All <i class="fa fa-hand-o-right"></i>',
                //'link'=>Url::to("/user/list")
            ]);?>
        </div>
    </div>


</div>









        <div class="body-content">


        </div>
    </div>
</div>

