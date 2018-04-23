<?php

class Product {
  const SHOW_BY_DEFAULT = 3;
    //возвращает массив продуктов или 10
    public static function getLatestProducts($count = self::SHOW_BY_DEFAULT) {
        $count = intval($count);
        //запрос к бд
             
        $db = Db::getConnection();
        $productsList = array();
        
        $result = $db->query("SELECT id, name, price, image, is_new "
                ." FROM product WHERE status = '1' ".
                " ORDER BY id DESC LIMIT ".$count);
        
        $i = 0;
       
        while ($row = $result->fetch(PDO::FETCH_ASSOC) ){
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['price'] = $row['price'];
            $productsList[$i]['image'] = $row['image'];
            $productsList[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        return $productsList;
       
    }
    
    public static function getRecommendedProducts()
    {   
        // Соединение с БД
        $db = Db::getConnection();

        // Получение и возврат результатов
        $result = $db->query('SELECT id, name, price, is_new FROM product '
                . 'WHERE status = "1" AND is_recommended = "1" '
                . 'ORDER BY id DESC');
        $i = 0;
        $productsList = array();
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['name'] = $row['name'];
            $productsList[$i]['price'] = $row['price'];
            $productsList[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        return $productsList;
    }
    
    
    public static function getProductsListByCategory($categoryId = false, $page=1) {
       
        
        if ($categoryId) {
            
            
            $page = intval($page);
            $offset = ($page-1)*self::SHOW_BY_DEFAULT;
            
        //запрос к бд
        $db = Db::getConnection();
        $products = array();
        
        $result = $db->query("SELECT id, name, price, image, is_new "
                ." FROM product WHERE status = '1'"
                ." AND category_id = '$categoryId' "
                ." ORDER BY id DESC LIMIT "
                .self::SHOW_BY_DEFAULT." OFFSET ".$offset);
        
        $i = 0;
       
        while ($row = $result->fetch(PDO::FETCH_ASSOC) ){
            $products[$i]['id'] = $row['id'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $products[$i]['image'] = $row['image'];
            $products[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        return $products;
       }
       
    }
    public static function getProductById($id) {
        $id = intval($id);
        
        if ($id) {
            
        //запрос к бд
        $db = Db::getConnection();
        $products = array();
        
        $result = $db->query("SELECT * FROM product WHERE id=".$id);
        $result ->setFetchMode(PDO::FETCH_ASSOC);
        $i = 0;
       
        return $result->fetch();
        }
        return $products;
       }
       
       
       public static function getTotalProductsInCategory($categoryId){
           
             $db = Db::getConnection();
        $products = array();
        
        $sql = "SELECT count(id) AS count FROM product WHERE status = '1' AND category_id = ".$categoryId;
        
        $result = $db->query($sql);
        $result ->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();
       
        return $row['count'];
       }
       
       
       
       
        public static function getProductsByIds($idsArray){
            
            
            $products =[];
            
            $db = Db::getConnection();
            $idsString = implode(',', $idsArray);    
        
        $sql = "SELECT * FROM product WHERE status = '1' AND id  IN ($idsString)";
        
        $result = $db->query($sql);
        $result ->setFetchMode(PDO::FETCH_ASSOC);
        
        
        $i = 0;
                
        while($row = $result->fetch()){
            $products[$i]['id'] = $row['id'];
            $products[$i]['name'] = $row['name'];
            $products[$i]['price'] = $row['price'];
            $products[$i]['code'] = $row['code'];
            
            $i++;
        }
        return $products;
        
            
        }
        public static function getImage($id)
    {
        // Название изображения-пустышки
        $noImage = 'no-image.jpg';

        // Путь к папке с товарами
        $path = '/upload/images/products/';

        // Путь к изображению товара
        $pathToProductImage = $path . $id . '.jpg';

        if (file_exists($_SERVER['DOCUMENT_ROOT'].$pathToProductImage)) {
            // Если изображение для товара существует
            // Возвращаем путь изображения товара
            return $pathToProductImage;
        }

        // Возвращаем путь изображения-пустышки
        return $path . $noImage;
    }

}
