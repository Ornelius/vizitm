<?php


namespace backend\controllers;


use yii\web\Controller;

class SlaveController extends Controller
{
    public function actionIndex()
    {
        print('Hello Denis & Karina');
    }

    public function actionSlave()
    {
        print('Slave');
    }

}