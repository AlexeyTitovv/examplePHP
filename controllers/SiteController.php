<?php 

include_once ROOT . '/models/Category.php';
include_once ROOT . '/models/Product.php';
   
class SiteController {
    public function actionIndex()
    {
        //категория
        $categories = array();
        $categories = Category::getCategoriesList();
        
        //послдение продукты 
        $latestProducts = array();
        $latestProducts = Product::getLatestProducts(6);
        
        //рекомедации слайдера 
         $sliderProducts = array();
        $sliderProducts = Product::getRecommendedProducts();
        
        require_once (ROOT.'/views/site/index.php');
        
        return true;
        
    
    }
    
    public function actionContact()  {
        
        $userEmail = false;
        $userText = false;
        $result = false;
        
        if(isset($_POST['submit'])) {
            $userEmail = $_POST['userEmail'];
            $userText = $_POST['userText'];
            
            $errors = false;
            
            //проверка заполнения
            
            if(User::checkEmail($userEmail)){
               //все верно
                }else{
                    $errors[] = "Email не верный!";
                }
                
                
            if($errors == false){
                //Почта администратора
                $adminEmail = "titoff1995@gmail.com";
                $message = "Текст: {$userText}. От {$userEmail}";
                $subject = "Контакты";
                $result = mail($adminEmail, $subject, $message);
                $result = true;
            }
        }
        
        
        require_once (ROOT . '/views/site/contact.php');
        return true;
       
   }    
   public function actionAbout()
    {
        // Подключаем вид
        require_once(ROOT . '/views/site/about.php');
        return true;
    }
}

