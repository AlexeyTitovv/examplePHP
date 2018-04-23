<?php


class UserController {
    
    public function actionRegister() {
        $name = '';
        $email = '';
        $password = '';
        $result = false;
        
        if(isset($_POST["submit"]) ) {
            
              $name = $_POST["name"];
              $email = $_POST["email"];
              $password = $_POST["password"];
              
              $errors = false;
              
              if(User::checkName($name) ){
                 // echo 'OK name';
              }
              else {
                  $errors[] = 'Имя дожно быть длинее 2 символов!';
              }
                
              if(User::checkEmail($email) ){
                 // echo 'OK email';
              }
              else {
                  $errors[] = 'Не правельный email!';
              }
              
              if(User::checkPassword($password) ){
                 // echo 'OK password';
              }
              else {
                  $errors[] = 'Пароль должен состоять из 6 символов!';
              }
              
              if(User::checkEmailExists($email)  ){
                  $errors[] = 'Такой Email уже существует!';
              }
              else {
                 // echo 'OK Email';
              }
              
              if($errors==false){
                  $result = User::register($name, $email, $password);
                  
              }
 
        }
         }
        
        public function actionLogin() {
        $email = '';
        $password = '';
                
        if(isset($_POST["submit"]) ) {
            
              $email = $_POST["email"];
              $password = $_POST["password"];
              
              $errors = false;
              
              if(User::checkEmail($email) ){
                 // echo 'OK email';
              }
              else {
                  $errors[] = 'Неправильная почта!';
              }
              
               if(User::checkPassword($password) ){
                 // echo 'OK password';
              }
              else {
                  $errors[] = 'Неправильный пароль!';
              }
              
              
              $userId = User::checkUserData ($email, $password);
              
              if ($userId==false){
                  //Если введенные параметры не правильные, выводим ошибку
                  $errors[] = 'Неправильные данные !';
              } else {
                  //Если введенные параметры правильные, запоминаем пользователя через сессию
                  User::auth($userId);
                  // Перенаправляем пользователя в кабинет (закрытая часть )
                  header("Location: /cabinet/");
              }
                  
              
        }
        
       
        
        
        
        
        
   
              
              require_once (ROOT.'/views/user/login.php');
        
        return true;
}


 public function actionLogout(){
     
     unset($_SESSION['user']);
     header("Location: /");
        }
}