<?php


class CartController{
    
    public function actionDelete($id)
    {      // Удаляем заданный товар из корзины
       if(Cart::deleteProduct($id))

        // Возвращаем пользователя в корзину
        header("Location: /cart");
    }
    
    public function actionAdd($id) {
        // Добавляем товар в корзину
        Cart::addProduct($id);
        // Возвращвем пользователя на страницу
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
}
            
    
    
    public function  actionAddAjax($id){
        
        echo Cart::addProduct($id);
        return true;
    }
    
    public function  actionIndex(){
        //создаем массив
        $categories = [];
        $categories = Category::getCategoriesList();
        
        $productsInCart = false;
        //получаем данные из корзины
        $productsInCart = Cart::getProducts();
        
        if($productsInCart) {
            
            $productsIds = array_keys($productsInCart);
            $products = Product::getProductsByIds($productsIds);
            
            
            $totalPrice = Cart::getTotalPrice($products);
             $totalQuantity = Cart::countItems();
            
        }
        
        require_once (ROOT.'/views/cart/index.php');;
        
        return true;
    }
    
    
    
    public function actionCheckout()
    {

        // Список категорий для левого меню
        $categories = array();
        $categories = Category::getCategoriesList();


        // Статус успешного оформления заказа
        $result = false;


        // Форма отправлена?
        if (isset($_POST['submit'])) {
            // Форма отправлена? - Да
            // Считываем данные формы
            $userName = $_POST['userName'];
            $userPhone = $_POST['userPhone'];
            $userComment = $_POST['userComment'];

            // Валидация полей
            $errors = false;
            if (!User::checkName($userName))
                $errors[] = 'Неправильное имя';
            if (!User::checkPhone($userPhone))
                $errors[] = 'Неправильный телефон';

            // Форма заполнена корректно?
            if ($errors == false) {
                // Форма заполнена корректно? - Да
                // Сохраняем заказ в базе данных
                // Собираем информацию о заказе
                $productsInCart = Cart::getProducts();
                if (User::isGuest()) {
                    $userId = false;
                } else {
                    $userId = User::checkLogged();
                }

                // Сохраняем заказ в БД
                $result = Order::save($userName, $userPhone, $userComment, $userId, $productsInCart);

                if ($result) {
                    // Оповещаем администратора о новом заказе                
                    $adminEmail = 'titoff1995@gmail.com';
                    $message = 'http://Project3/admin/orders';
                    $subject = 'Новый заказ!';
                    $result1 = mail($adminEmail, $subject, $message);
                    
                    //Проверка на отправку
                   // var_dump($result1);

                    // Очищаем корзину
                    Cart::clear();
                }
            } else {
                // Форма заполнена корректно? - Нет
                // Итоги: общая стоимость, количество товаров
                $productsInCart = Cart::getProducts();
                $productsIds = array_keys($productsInCart);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();
            }
        } else {
            // Форма отправлена? - Нет
            // Получием данные из корзины      
            $productsInCart = Cart::getProducts();

            // В корзине есть товары?
            if ($productsInCart == false) {
                // В корзине есть товары? - Нет
                // Отправляем пользователя на главную искать товары
                header("Location: /");
            } else {
                // В корзине есть товары? - Да
                // Итоги: общая стоимость, количество товаров
                $productsIds = array_keys($productsInCart);
                $products = Product::getProductsByIds($productsIds);
                $totalPrice = Cart::getTotalPrice($products);
                $totalQuantity = Cart::countItems();


                $userName = false;
                $userPhone = false;
                $userComment = false;

                // Пользователь авторизирован?
                if (User::isGuest()) {
                    // Нет
                    // Значения для формы пустые
                } else {
                    // Да, авторизирован                    
                    // Получаем информацию о пользователе из БД по id
                    $userId = User::checkLogged();
                    $user = User::getUserById($userId);
                    // Подставляем в форму
                    $userName = $user['name'];
                }
            }
        }

        require_once(ROOT . '/views/cart/checkout.php');

        return true;
    }
    
}
