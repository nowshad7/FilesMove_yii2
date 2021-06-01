<?php


namespace frontend\controllers;


use yii\web\Controller;

class TestController extends Controller
{
    public function actionTest()
    {
        $org = 'uploads/pdf/FileName_1.pdf';
        $prefix = 'uploads/pdf/FileName_';

        for($x =2; $x<=2000;$x++){
            $copy =  $prefix.$x.'.pdf';
            $flag = copy($org,$copy);
        }
        echo '2000 pdf generated!';
    }
}
