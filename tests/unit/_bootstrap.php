<?php
// Here you can initialize variables that will be available to your tests

function getUser(){
    $user = new \app\models\User();
    $user->name = 'tester';
    $user->email = 'tester@mail.ru';
    $user->setPassword('12345');

    $user->save();
    return $user;
}

function getRandProduct(){
    $products = \app\models\Product::find()->all();
    $randProduct = $products[mt_rand(0,count($products)-1)];

    return $randProduct;
}

function getCart(){
    $uuid = '537942e5-68a2-e785-235a-3ce24affcf45';
    $cartHandler = new \app\logic\busket\CartHandler($uuid);
    $cartHandler->createCart();

    return $cartHandler->getCart();
}