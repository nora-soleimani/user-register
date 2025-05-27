<?php
require_once ("DBConnection.php");
require_once ("assets/controler/LoginClass.php");
require_once ("assets/controler/LogClass.php");
require_once("jdf.php");

class User extends connection{
    public $con;
    public $photo;
    public $listmaneger;
    public $lists;
    public function __construct(){
      
        $this->con =$this->connection();
    }


//convert date miladi to jalali
    public function ConverToJalali(){
        date_default_timezone_set("Asia/Tehran");
        $data = date("Y-m-d");
        $fulldate = explode('-', $data);
        $year = $fulldate[0];
        $month = $fulldate[1];
        $day = $fulldate[2];
        $jalali = gregorian_to_jalali($year, $month, $day, '/');
        return $jalali;

    }

//show information user
    public function showUser($id){
        $sql="SELECT users.first_name, users.last_name , users.national_code , users.phone_number , users.birth_date , users.gender , users.photo , users.username , users.email ,provinces.ProvinceName ,cities.CityName from users 
        INNER JOIN provinces on provinces.IDProvince=users.province_id
        INNER JOIN cities on cities.IDCity=users.city_id
        where users.id='$id'";
        $result=$this->con->query($sql);
       

        if($result->num_rows!=0){ 
            $result=$this->con->query($sql);
            return $result->fetch_assoc(); 
        }
        else{
            $sql="SELECT users.first_name, users.last_name , users.national_code , users.phone_number , users.birth_date , users.gender , users.photo , users.username , users.email from users 
                where users.id='$id'";
                $result=$this->con->query($sql);
                return $result->fetch_assoc();
        }
    }

    //show information users
    public function show_usrs(){
        $sql ="SELECT users.id,users.first_name, users.last_name , users.national_code , users.phone_number , users.birth_date , users.gender , users.username , users.email  from users 
        where users.IDLevel ='4'";
        $result=$this->con->query($sql);
        $this->lists=[];
        $i=0;
        while($row= $result->fetch_assoc()){
            $this->lists[$i]=$row;
            $i++;
            
        }

    }

//show information admins
    public function showAdmin(){
        $sql="SELECT users.first_name, users.last_name , users.email ,level.NameLevel,users.id ,users.IDLevel  from users 
        INNER JOIN level on level.IdLevel=users.IDLevel where users.IDLevel <4";
        $result=$this->con->query($sql);
        $this->listmaneger=[];
        $i=0;
        while($row= $result->fetch_assoc()){
            $this->listmaneger[$i]=$row;
            $i++;
            
        }
    }

//create information user
    public function CreateUser($data,$time,$photo){

        foreach($data as $key=>$value){
            ${$key}=$value;
        }
        date_default_timezone_set("Iran");
        $password = md5($_POST['password']);
        if (empty($province)){
            $sql = "INSERT INTO users (first_name, last_name, national_code, phone_number, birth_date, gender, email, photo, username, password, province_id, city_id,verify,IDLevel,created_at)
            VALUES ('$firstName', '$lastName', '$nationalCode', '$phoneNumber', '$birthDate', '$gender', '$email', '$photo', '$username', '$password', null, null,'0','4','$time')";
       
        }
        elseif(empty($city)){
            $city=null;
            $sql = "INSERT INTO users (first_name, last_name, national_code, phone_number, birth_date, gender, email, photo, username, password, province_id, city_id,verify,IDLevel,created_at)
            VALUES ('$firstName', '$lastName', '$nationalCode', '$phoneNumber', '$birthDate', '$gender', '$email', '$photo', '$username', '$password', '$province', null,'0','4','$time')";
       
        }else{

            $sql = "INSERT INTO users (first_name, last_name, national_code, phone_number, birth_date, gender, email, photo, username, password, province_id, city_id,verify,IDLevel,created_at)
            VALUES ('$firstName', '$lastName', '$nationalCode', '$phoneNumber', '$birthDate', '$gender', '$email', '$photo', '$username', '$password', '$province', '$city','0','4','$time')";
        
        }
       
        $row=$result=$this->con->query($sql);
        if ($result === TRUE) {
            $sql2 = "SELECT id FROM users where national_code='$nationalCode'";
            $result2=$this->con->query($sql2);
            $row2=$result2->fetch_assoc();
            $_SESSION["ID_User"]=$row2["id"];
            $_SESSION["LevelID"]=$row2["iIDLeveld"];
            $message = "ثبت نام با موفقیت انجام شد";
            header("Location: register.php?message=" . urlencode($message) . "&type=success");
            exit();
        } else {
            $message = "خطا در ثبت نام";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }
         
    }

    //create information user admin
    public function CreateAdmin($data,$time,$photo){
  
        foreach($data as $key=>$value){
            ${$key}=$value;
        }
        date_default_timezone_set("Iran");
        $password = md5($_POST['password']);

        if (empty($province)){
            $province=null;
            $city=null;
        }
        elseif(empty($city)){
            $city=null;
        }
        $sql = "INSERT INTO users (first_name, last_name, national_code, phone_number, birth_date, gender, email, photo, username, password, province_id, city_id,verify,IDLevel,created_at)
            VALUES ('$firstName', '$lastName', '$nationalCode', '$phoneNumber', '$birthDate', '$gender', '$email', '$photo', '$username', '$password', '$province', '$city','0','3',$time)";
        
        $row=$result=$this->con->query($sql);
        if ($result === TRUE) {
            $sql2 = "SELECT id FROM users where national_code='$nationalCode'";
            $result2=$this->con->query($sql2);
            $row2=$result2->fetch_assoc();
            $_SESSION["ID_User"]=$row2["id"];
            $id=$_SESSION["ID_User"];
            $sql3="INSERT INTO admin(Iduser,Username ,Idlevel ) VALUES ('$id','$username' ,'3' )";

            $result3=$this->con->query($sql3);

            $message = "ثبت نام با موفقیت انجام شد";
            header("Location: register.php?message=" . urlencode($message) . "&type=success");
            exit();
        } else {
            $message = "خطا در ثبت نام";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }
         
    }



//edit information user 
    public function Edit($id){
        $sql="SELECT users.first_name,provinces.ProvinceName,provinces.IDProvince,cities.IDCity,cities.CityName , users.password ,users.last_name , users.national_code , users.phone_number , users.birth_date , users.gender , users.photo , users.username , users.email ,provinces.ProvinceName ,cities.CityName from users 
        INNER JOIN provinces on provinces.IDProvince=users.province_id
        INNER JOIN cities on cities.IDCity=users.city_id
        where users.id='$id'";
        $result=$this->con->query($sql);
    

        if($result->num_rows!=0){ 
            $result=$this->con->query($sql);
            return $result->fetch_assoc(); 
        }
        else{
            $sql="SELECT users.first_name,users.password, users.last_name , users.national_code , users.phone_number , users.birth_date , users.gender , users.photo , users.username , users.email  from users 
                where users.id='$id'";
                $result=$this->con->query($sql);
               return  $result->fetch_assoc();
        }
          
    }   


//update user
    public function update_User($data,$photo,$id){
        $log=new Log();
        foreach($data as $key=>$value){
            ${$key}=$value;
        }

        $sql1="SELECT password FROM users where id='$id'";
        $result1=$this->con->query($sql1);
        $row=$result1->fetch_assoc();
        
        if($row["password"]!=$password){
            $password = md5($password);
        }

        if ($photo==""){   
            $sql="UPDATE users set first_name='$firstName', last_name='$lastName',phone_number='$phoneNumber',birth_date='$birthDate',gender='$gender',username='$username', password='$password', province_id ='$province' , city_id  ='$city' where id ='$id'";
        }
        else{
            $sql="UPDATE users set first_name='$firstName', last_name='$lastName',phone_number='$phoneNumber',birth_date='$birthDate',gender='$gender',username='$username', password='$password', photo='$photo',province_id ='$province' , city_id  ='$city' where id ='$id'";
        }
        
       
        $result=$this->con->query($sql);
       
        $log->logChange($id,$_SESSION["ID_User"],"ویرایش اطلاعات");
        $message = "اطلاعات شما ویرایش شد";
            header("Location: profile.php?message=" . urlencode($message) . "&type=success");
            exit();
    }

    //edit information users 
    public function Editusers($id){
        $sql="SELECT  users.password  from users where users.id='$id'";
        $result=$this->con->query($sql);
        return $result->fetch_assoc();   
    }   

    //edit information users 
    public function Updateusersn($password,$id){
        $log=new Log();
        $sql1="SELECT password FROM users where id='$id'";
        $result1=$this->con->query($sql1);
        $row=$result1->fetch_assoc();
        
        if($row["password"]!=$password){
            $password = md5($password);

            $sql="UPDATE users set  users.password='$password' where users.id='$id'";

            $result=$this->con->query($sql);


            $log->logChange($id,$_SESSION["ID_User"],"اپدیت پسورد کاربر");
        }   
        $message = "اطلاعات شما ویرایش شد";
        header("Location: users.php?message=" . urlencode($message) . "&type=success");
        exit(); 
    }

///upload photo
    public function upload_photo($file){

        // چک کردن خطا
        if ($_FILES['photo']['error'] != 0) {
            $message = "خطا در اپلود عکس";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }

        // چک کردن فرمت عکس
        $allowedTypes = ['image/jpeg', 'image/png'];
        $fileType = mime_content_type($_FILES['photo']['tmp_name']);
        if (!in_array($fileType, $allowedTypes)) {
            $message = "فرمت فایل نامعتبر است. لطفا عکس با فرمت JPEG، PNG آپلود کنید.";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }

        // چک کردن حجم فایل
        if ($_FILES['photo']['size'] > 200 * 1024) { // 200KB
            $message = "حجم فایل بیشتر از 200KB است.";
            header("Location: register.php?message=" . urlencode($message) . "&type=error");
            exit();
        }

        // تولید نام تصادفی برای فایل
        $fileExt = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $newFileName = uniqid('img_', true) . '.' . $fileExt;
        $uploadDir = getcwd() . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;
            
        $uploadPath = $uploadDir . $newFileName;

        // دریافت ابعاد عکس
        list($width, $height) = getimagesize($_FILES['photo']['tmp_name']);
        if ($width !== 400 || $height !== 400) {
            // تغییر اندازه عکس
            $newWidth = 400;
            $newHeight = 400;
            $srcImage = null;

            switch ($fileType) {
                case 'image/jpeg':
                    $srcImage = imagecreatefromjpeg($_FILES['photo']['tmp_name']);
                    break;
                case 'image/png':
                    $srcImage = imagecreatefrompng($_FILES['photo']['tmp_name']);
                    break;
            }

            $dstImage = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

            // ذخیره عکس تغییر اندازه داده شده
            switch ($fileType) {
                case 'image/jpeg':
                    imagejpeg($dstImage, $uploadPath);
                    break;
                case 'image/png':
                    imagepng($dstImage, $uploadPath);
                    break;
            }

            imagedestroy($srcImage);
            imagedestroy($dstImage);

        } else {
            // ذخیره عکس بدون تغییر اندازه
            move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath);

        }
        return $newFileName;

    }


///call fuction create new user
    public function CreateNewUser(){
        $Users=new User();
        if($_FILES['photo']['size']==0){
            $photo="";
        }
        else{
            $photo=$Users->upload_photo($_FILES['photo']);        
        }
        $time=$Users->ConverToJalali();
        
        $Users->CreateUser($_POST,$time,$photo);
    }

    ///call fuction create new admin
    public function CreateNewAdmin(){
        $Users=new User();
        if($_FILES['photo']['size']==0){
            $photo="";
        }
        else{
            $photo=$Users->upload_photo($_FILES['photo']);        
        }
        $time=$Users->ConverToJalali();
        $Users->CreateAdmin($_POST,$time,$photo);
    }

    ///call fuction update  user
    public function UpdateUser($id){
        $Users=new User();
        if($_FILES['photo']['size']==0){
            $photo="";
        
        }
        else{
            $photo=$Users->upload_photo($_FILES['photo']);        
        }
        $Users->update_User($_POST,$photo,$id);
    }
    

}



  


    




?>
