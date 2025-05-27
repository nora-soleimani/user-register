<?php
require_once ("DBConnection.php");

class Validation extends connection{
    public $con;
    public function __construct(){
      
        $this->con =$this->connection();

    }
///Check that the fields are empty
    public function ch_empty(){
        if (empty($_POST["firstName"])==1) {
            $message = "لطفا نام خود را وارد کنید";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();

        }
        else if (empty($_POST["lastName"])==1) {       
            $message = "لطفا نام خانوادگی خود را وارد کنید";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }
        else if (empty($_POST["nationalCode"])==1) {       
            $message = "لطفا کد ملی خود را وارد کنید";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }
        else if (empty($_POST["phoneNumber"])==1) {       
            $message = "لطفا شماره موبایل خود را وارد کنید";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }
        else if (empty($_POST["gender"])==1) {       
            $message = "لطفا جنسیت خود را مشخص کنید";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }
        else if (empty($_POST["email"])==1) {       
            $message = "لطفا ایمیل خود را وارد کنید";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }
        else if (empty($_POST["username"])==1) {       
            $message = "لطفا نام کاربری خود را وارد کنید";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }
        else if (empty($_POST["password"])==1) {       
            $message = "لطفا پسورد خود را وارد کنید";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }
        else{ 
            return "ok";
        }
    }

//check that the IDCode is true
    public function ch_IDCode(){
        $nationalCode=$_POST["nationalCode"];
        if (!preg_match('/^[0-9]{10}$/', $nationalCode)) {
            $message = "فرمت کد ملی اشتباه است.";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }
    
        $checkDigit = intval(substr($nationalCode, 9, 1));
        $sum = 0;
    
        for ($i = 0; $i < 9; $i++) {
            $sum += intval(substr($nationalCode, $i, 1)) * (10 - $i);
        }
    
        $remainder = $sum % 11;
    
        if(($remainder < 2 && $checkDigit == $remainder) || ($remainder >= 2 && $checkDigit == (11 - $remainder))) {
            return "ok";
        }
        else{
            $message = "فرمت کد ملی اشتباه است.";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }
    }

    
//check the non-repetitive national_code
    public function ch_repeatId(){
        $sql="SELECT national_code FROM users where national_code='$_POST[nationalCode]'";
        $result=$this->con->query($sql);
        $row=$result->fetch_assoc();
        if($result->num_rows!=0){
            $message = "این کد ملی قبلا ثبت شده است.";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }
        else{
            return "ok";
        }
    }
//check the non-repetitive Username
    public function ch_repeatUsername(){
        $sql="SELECT username  FROM users where username='$_POST[username]'";
        $result=$this->con->query($sql);
        $row=$result->fetch_assoc();
        if($result->num_rows!=0){
            $message = "این نام کاربری قبلا ثبت شده است.";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }
        else{
            return "ok";
        }
    }

//format emil
    public function ch_formatemail(){
        $email = ($_POST["email"]);
       
        if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)){ 
            $message = "فرمت ایمیل نادرست است.";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }
        else{
            return "ok";
        }
    }

//format phone number
    public function ch_formatPhonNumber(){
        $phonenumber = ($_POST["phoneNumber"]);
        
        $len=strlen($_POST["phoneNumber"]);
        if($len==11){
            if (!preg_match("/^[0]{1}[9]{1}\d{9}$/",  $phonenumber)) {
                $message = "فرمت شماره تماس اشتباه است.";
                header("Location: register.php?message=" . urlencode($message) . "&type=error");
                exit();
            }
            else{
                return "ok";
            }
        }
        else{
            return  $message = "تعداد ارقام نادرست است";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }
    
    }
//format birthday
    public function ch_birtiday(){
        date_default_timezone_set("Iran");
        $databairthday = $_POST["birthDate"];
        $fulldate = explode('-',$databairthday);
        $year =(int) $fulldate[0];
        $nowYear=date('Y');
        $ch=(int)$nowYear-$year;
        if($ch<10){
            $message = "افراد کمتر از 10 سال اجازه ثبت نام ندارند.";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }
        else{
            return "ok";
        }
            
    }

//format username
    public function ch_username(){
        $username=$_POST["username"];
        if (!preg_match("/^[a-zA-Z][a-zA-Z0-9_]{5,49}$/",  $username)) {
            $message = "فرمت نام کاربری اشتباه است";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }
        else{
            return "ok";
        }
    }
    
//check repassword
    public function Re_password(){
        $pass=$_POST["password"];
        $Repass=$_POST["confirmPassword"];
        if($pass!==$Repass){
            $message = "پسورد ناهماهنگ است. دوباره تلاش کنید.";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }
        else{
            return "ok";
        }
    }
    //برسی کپچا//
    public function capcha(){
        if (isset($_POST['captcha']) && isset($_SESSION['captcha_text'])) {
        $user_input = $_POST['captcha'];
        $captcha_text = $_SESSION['captcha_text'];

        if ($user_input === $captcha_text) {
           return "ok";
        } else {
            $message = "capcha اشتباه است .لطفا دوباره امتحان کنید";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }
        } else {
            $message = "خطایی رخ داده دوباره امتحان کنید";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }
    }

    public function check(){
        $vaidation=new Validation();
          
        $data=$vaidation->ch_empty($_POST);
        if($data=="ok"){
            $data=$vaidation->ch_IDCode($_POST);

            if($data=="ok"){
                $data=$vaidation->ch_repeatId($_POST);

                if($data=="ok"){
                    $data=$vaidation->ch_repeatUsername($_POST);
        
                    if($data=="ok"){
                        $data=$vaidation->ch_formatemail($_POST);
            
                        if($data=="ok"){
                            $data=$vaidation->ch_formatPhonNumber($_POST);
                
                            if($data=="ok"){
                                if($_POST["birthDate"]!=""){
                                    $data=$vaidation->ch_birtiday($_POST);
                                }
                            
                                if($data=="ok"){
                                    $data=$vaidation->ch_username($_POST);
                        
                                    if($data=="ok"){
                                        if($_POST["confirmPassword"]!=""){
                                            $data=$vaidation->Re_password($_POST);
                                        }
                                        if($data=="ok"){
                                            $data=$vaidation->capcha($_POST);
                                        }
                
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

}