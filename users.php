<?php 

require_once ("assets/controler/UserClass.php");

$Users=new User();
$Users->show_usrs();


if (isset($_GET["action"])) {
    if ($_GET["action"] == "edit") {
        $action="edit";
        $useredit=$Users->Editusers($_GET["id"]);
    } 

    if($_GET["action"]=="exit"){
        session_destroy();
        header("location:login.php");
    }
}
if(isset($_POST["update"])){
    $Users->Updateusersn($_POST["password"],$_GET["id"]);
    $action="false";      
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/public/css/style.css">

    <title>لیست کاربران</title>

</head>

<body>

<?php if(isset($_SESSION["ID_User"])){
  
        if($_SESSION["LevelID"]>=3){
       
             echo  '<script type=text/javascript>alert(" شما اجازه ورد به این صفحه را ندارید  ")</script>' ;
            
            header("Refresh: 0 ;http:Login.php");
        } 
        elseif($_SESSION["LevelID"]<=3){
   
      ?>
    <!-- نوبار -->
    <nav class="navbar">
        <ul>
            <li><a href="login.php">داشبورد</a></li>
            <li><a href="profile.php">پروفایل</a></li>
            <li><a href="users.php">لیست کاربران</a></li>
            <li><a href="maneger.php">لیست مدیران </a></li>
            <li><a href="state.php">لیست استان ها</a></li>
            <li><a href="Report.php"> گزارش گیری</a></li>
            <li><a href="log.php">مشاهده تغییرات کاربران</a></li>
            <li><a href="?action=exit">خروج</a></li>

        </ul>
    </nav>
    <?php 
        }else{ 
           
                ?>
    <nav class="navbar">
    <ul>
        <li><a href="login.php">داشبورد</a></li>
        <li><a href="profile.php">پروفایل</a></li>
        <li><a href="?action=exit">خروج</a></li>
    </ul>
    </nav>
    <?php
        }
        ?>
    <!-- جدول اطلاعات کاربر -->
    <div class="table-container">
        <a href="search.php">جست و جو</a>

        <h2>اطلاعات کاربر</h2>

        <?php if (isset($_GET['message'])): 
            if($_GET['type']=="success"){?>
                <div class="message <?php echo htmlspecialchars($_GET['type']); ?>">
                    <?php echo htmlspecialchars($_GET['message']); ?>
                </div>
                <?php
            }
            ?>      
        <?php endif; ?>
        <table>
            <tr>
                <th>نام</th>
                <th>نام خانوادگی</th>
                <th>کد ملی</th>
                <th>شماره همراه</th>
                <th>تاریخ تولد</th>
                <th>جنسیت</th>
                <th>ایمیل</th>
                <th>نام کاربری</th>
                <th>ویرایش</th>
                <th>حذف</th>
            </tr>
            <?php
            foreach($Users->lists as $value){ 
                ?>
            <tr>
               
                <td><?php echo $value["first_name"]; ?></td>
                <td><?php  echo $value["last_name"]; ?></td>
                <td><?php  echo $value["national_code"]; ?></td>
                <td><?php  echo $value["phone_number"]; ?></td>
                <td><?php  echo $value["birth_date"]; ?></td>
                <td><?php if($value["gender"]=="male"){ echo "مرد";}else{ echo "زن" ;} ?></td>
                <td><?php  echo $value["email"]; ?></td>
                <td><?php  echo $value["username"]; ?></td>
                <td><a href="users.php?action=edit&id=<?php echo $value["id"] ?>">ویرایش</a></td>
                <td><a href="users.php?action=Delet&id=<?php echo $value["id"] ?>">حذف</a></td>
            </tr>
            <?php 
            }
            ?>
        </table>
    </div>
    <?php 
    if (isset($_GET["action"])) {
        if ($_GET["action"] == "edit") {

        ?>
           <div class="form-container">
                <h2> تغییر رمز عبور</h2>
                <?php if (isset($_GET['message'])): ?>
                <div class="message <?php echo htmlspecialchars($_GET['type']); ?>">
                    <?php echo htmlspecialchars($_GET['message']); ?>
                </div>
                <?php endif; ?>
                <form action="" method="post">
                   
                                
                    <div class="form-group">
                        <label for="password">تغییر رمز عبور : </label>
                        <input type="password" id="password" name="password" value="<?php if(isset($useredit)){echo $useredit["password"];} ?>" required>
                    </div>
                    
                    
                    <button type="submit"  name="update">ویرایش</button>
                </form>     

            </div>
        <?php

        }
    }
}
    else{
        echo  '<script type=text/javascript>alert(" شما اجازه ورد به این صفحه را ندارید  ")</script>' ;
        header("Refresh: 0;location:login.php");
    }?>

</body>

</html>

