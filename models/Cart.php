<?php

class Cart {
    
    public static function addProduct($id) {
        
       $id = intval($id);
       
       //создаем пустой массив для товаров в корзине
       $productsInCart = [];
       //если в корзине есть товары
        if(isset($_SESSION['products'])){
            //Тогда заполняем массив товарами 
            $productsInCart = $_SESSION['products'];
        }
        //если товар уже был в корзине и его добавили еще раз, тогда +1 к сущестующему
        if(array_key_exists($id, $productsInCart)){
            $productsInCart[$id]++; 
            }else{
                //добовляем новый товар в корзину
                $productsInCart[$id] = 1;
                
            }
            
            $_SESSION['products']= $productsInCart;
            
                      
            //echo '<pre>';
            //print_r($_SESSION['products']);
            //die();
            return self::countItems();
    }
    
    public static function countItems() {
        
        if(isset($_SESSION['products'])){
            $count = 0;
            foreach($_SESSION['products'] as $id => $quantity ){
                $count = $count + $quantity;
            }
            return $count;
        } else {
            return 0;    
        }
        
    }
    
    public static function getProducts() {
        
        if (isset($_SESSION['products'])){
            return $_SESSION['products'];
        }
        return false;
    }
    
    public static function getTotalPrice($products) {
        
        $productsInCart = self::getProducts();
        
        if($productsInCart){
            $total = 0;
            foreach ($products as $item){
                $total+=$item['price'] * $productsInCart[$item['id']];
                
            }
        }
        return $total;
    }
    
    public static function clear(){
        if(isset($_SESSION['products'])){
            unset($_SESSION['products']);
        }
    }
    
    public static function deleteProduct($id)
    {$id = intval($id);
        // Получаем массив с идентификаторами и количеством товаров в корзине
        $productsInCart = $_SESSION['products'];
        
if (array_key_exists($id, $productsInCart)) {
            // Если такой товар есть в корзине, уменьшим количество на 1
$productsInCart[$id] -- ;}
 if($productsInCart[$id]<=0){
        // Удаляем из массива элемент с указанным id
 unset($productsInCart[$id]);}

        // Записываем массив товаров с удаленным элементом в сессию
        $_SESSION['products'] = $productsInCart;
        return self::countItems();
    }
}



