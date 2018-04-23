<?php


class CabinetController {
    
    public function actionIndex() {
        
        //получаем ID пользователя из сессии
        $userId = User::checkLogged();
        
        //Получаем инфу о пользователе из БД
        $user = User::getUserById($userId);
        
        
        require_once (ROOT.'/views/cabinet/index.php');
        
        return true;
        
    }
    
    
   public function actionEdit() {
       
       //получаем ID пользователя из сессии
        $userId = User::checkLogged();
        
        //Получаем инфу о пользователе из БД
        $user = User::getUserById($userId);
        
        $name = $user['name'];
        $password = $user['password']; //11111111111111111111111111111111111111111111111
        
        $result = false;
        
         if(isset($_POST["submit"]) ) {
            
              $name = $_POST["name"];
              $password = $_POST["password"];
              
              $errors = false;
              
        if(User::checkName($name) ){
                 // echo 'OK name';
              }
              else {
                  $errors[] = 'Имя дожно быть длинее 2 символов!';
              }
              
               if(User::checkPassword($password) ){
                 // echo 'OK password';
              }
              else {
                  $errors[] = 'Пароль должен состоять из 6 символов!';
              }
              
              if($errors==false){
                  $result = User::edit($userId, $name, $password);
                  
              }
   }
   
    require_once (ROOT.'/views/cabinet/edit.php');
        
        return true;
}
}