<?php



return array(
    'about'=>'site/about/',
    'product/([0-9]+)' => 'product/view/$1', //actionView в productController
    
    'catalog' => 'catalog/index', //actionIndex в catalogController
    
    'category/([0-9]+)/page-([0-9]+)' => 'catalog/category/$1/$2', //actionCategory в catalogController
    
    'category/([0-9]+)' => 'catalog/category/$1', //actionCategory в catalogController
    
     'cart/delete/([0-9]+)' => 'cart/delete/$1', // actionDelete в CartController
    'cart/checkout' => 'cart/checkout', // actionCheckOut в CartController    
     
    'cart/add/([0-9]+)'=> 'cart/add/$1',
     
    'cart/addAjax/([0-9]+)'=> 'cart/addAjax/$1',
    'cart'=> 'cart/index',
    
    'contacts' => 'site/contact', 
    'user/register' => 'user/register',
    'cabinet/edit' => 'cabinet/edit',
    'cabinet' => 'cabinet/index',
    
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',
    
    
       
    
    '' => 'site/index', //actionIndex в siteController

);

