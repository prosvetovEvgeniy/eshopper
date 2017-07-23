<?php
/**
 * Created by PhpStorm.
 * User: Евгений
 * Date: 09.07.2017
 * Time: 23:04
 */

namespace app\controllers;


use yii\web\Controller;

class AppController extends Controller
{
    protected function setMetaTags($title = null, $keywords = null, $description = null){
        $this->view->title = $title;
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => "$keywords"]);
        $this->view->registerMetaTag(['name' => 'description', 'content' => "$description"]);
    }
}