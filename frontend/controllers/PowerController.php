<?php


namespace frontend\controllers;
use yii\web\Controller;

class PowerController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}