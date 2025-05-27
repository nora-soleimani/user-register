<?php
require_once ("DBConnection.php");
require_once ("UserClass.php");
require 'vendor/autoload.php';


//use calss PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



class Vrify extends connection{
    public $con;
    public function __construct(){
      
        $this->con =$this->connection();

    }

// send email for user
    public function SendEmail(){

        $sql="SELECT * from verify where Cod ='$_SESSION[ID_User]'";
        $result=$this->con->query($sql);
        $row=$result->fetch_assoc();
        $id=$_SESSION["ID_User"];
        if($result->num_rows!=0){ 
            $_SESSION['cod']=$row["Cod"];
            $code=$row["Cod"];
            
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'noraslmtestprj@gmail.com';
                $mail->Password ='loyb hgfu vhbu agra';
                //$mail->Password = 'Testproject$002';
                
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom('noraslmtestprj@gmail.com', 'soleimani');
                $mail->addAddress($Email);
                $mail->isHTML(true);
                $mail->Subject = "کد تایید ایمیل";
                $mail->Body = "خوش آمدید، ایمیل شما: $email <br>کد تایید شما: $code";
                $mail->send();
                $message = "لطفا کد ارسال شده به ایمیل خود را وارد کنید:";
                header("Location: verifyform.php?message=" . urlencode($message) . "&type=success");
                exit();
            } catch (Exception $e) {
                $message = "خطا در ارسال ایمیل";
                header("Location: verifyform.php?message=" . urlencode($message) . "&type=error");
                exit();
            }
        }
        else{
            $sql1="SELECT * from users where id ='$id'";
            $result1=$this->con->query($sql1);
            $row1=$result1->fetch_assoc();
            $email = $row1["email"];
            $code=rand(100000,99999999);
            $sql="INSERT INTO verify (IDuser ,Email,Cod) VALUES ('$id','$email','$code')";
            $result=$this->con->query($sql);
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'noraslmtestprj@gmail.com';
                $mail->Password ='loyb hgfu vhbu agra';
                //$mail->Password = 'Testproject$002';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom('noraslmtestprj@gmail.com', 'soleimani');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = "کد تایید ایمیل";
                $mail->Body = "خوش آمدید، ایمیل شما: $email <br>کد تایید شما: $code";
                $mail->send();
                $message = "لطفا کد ارسال شده به ایمیل خود را وارد کنید:";
                header("Location: verifyform.php?message=" . urlencode($message) . "&type=success");
                exit();
            } catch (Exception $e) {
                $message = "خطا در ارسال ایمیل";
                header("Location: verifyform.php?message=" . urlencode($message) . "&type=error");
                exit();
            }

        }
       
    }


// check cod is true
    public function checkCode($cod){
        $sql="SELECT *  FROM verify where IDuser='$_SESSION[ID_User]'";
        $result=$this->con->query($sql);
        $row=$result->fetch_assoc();
        if($result->num_rows!=0){
        
            if($row["Cod"]==$cod){    
                $sql="UPDATE `users` SET `verify`='1' WHERE id ='$_SESSION[ID_User]'";
                $result=$this->con->query($sql);
                $message = "ایمیل شما تایید شد   ";
                header("Location: verifyform.php?message=" . urlencode($message) . "&type=successemail");
                exit();
            }
            
            else{
            $message = "کد تایید اشتباه وارد شده";
                header("Location: verifyform.php?message=" . urlencode($message) . "&type=error");
                exit();
        

            }
        }

    }
}