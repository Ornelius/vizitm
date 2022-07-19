<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;
use vizitm\entities\Users;
/* @var $this yii\web\View */
/* @var $model vizitm\entities\Users */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="users-view">

    <?php if (Yii::$app->session->hasFlash('error')):  ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-exclamation-circle" aria-hidden="true"> <?= Yii::$app->session->getFlash('error') ?></i>
        </div>
    <?php endif; ?>
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
