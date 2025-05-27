<?php
require_once ("DBConnection.php");

class login extends connection{
    public $con;
    public function __construct(){
      
        $this->con =$this->connection();

    }
////login
    public function login(){

        $password = md5($_POST['password']);
        $sql="SELECT users.id ,users.verify, users.first_name ,level.IdLevel FROM users 
        INNER JOIN level ON users.IDLevel=level.IdLevel
        where users.username='$_POST[username]' and password='$password'";
        $result=$this->con->query($sql);
        $row=$result->fetch_assoc();

        if($result->num_rows!=0){ 
            $_SESSION["verify"]=$row["verify"];
            if($row["verify"]==1){
                $_SESSION["LevelID"]=$row["IdLevel"];
                $_SESSION["ID_User"]=$row["id"];
                $_SESSION["name"]=$row["first_name"];
                $message = "خوش آمدید";
                header("Location: login.php?message=" . urlencode($message) . "&type=success");
                exit();
               
            }
            else{
                $message = "لطفا ابتدا ایمیل خود را تایید کنید";
                header("Location: verifyform.php?message=" . urlencode($message) . "&type=error");
                exit();
            } 
        }
        else{  
            $message = "نام کاربری یا رمز عبور اشتباه است ";
                header("Location: login.php?message=" . urlencode($message) . "&type=error");
                exit();  
        }
        
    }
}