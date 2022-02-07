<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use vizitm\entities\Users;
/* @var $this yii\web\View */
/* @var $model vizitm\entities\Users */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Active', ['active', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Inactive', ['inactive', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php
            if($model->username !== 'admin') {
                echo Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]);
            }
        ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            //'auth_key',
            'email:email',
            [
                'attribute'     => 'status',
                'filter'        => \vizitm\helpers\UserHelper::statusList(),
                'value'         => function (Users $users) {
                    return \vizitm\helpers\UserHelper::statusLabel($users->status);
                },
                'format'        => 'raw',

            ],

            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
