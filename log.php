<?php 
require_once ("assets/controler/LoginClass.php");
require_once ("assets/controler/LogClass.php");

$log=new Log();

$log->show_Log();

if (isset($_GET["action"])) {

    if($_GET["action"]=="exit"){
        session_destroy();
        header("location:login.php");
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/public/css/style.css">
    <link rel="stylesheet" href="./assets/public/css/pikaday.css">
    <link rel="stylesheet" href="./assets/public/css/persian-datepicker.min.css">
    <title>پروفایل</title>

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
        <h2>اطلاعات لاگ  کاربران</h2>

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
               
                <th>نام کاربر</th>
                <th>نام ادمین</th>
                <th>نوع تغییر</th>
                <th>تاریخ </th>

            </tr>
            <?php
            foreach($log->listlog as $value){ 
                ?>
            <tr>
               
                <td><?php  echo $value["username"]; ?></td>
                <td><?php  echo $value["nameadmin"]; ?></td>
                <td><?php  echo $value["Action"]; ?></td>
                <td><?php  echo $value["CreatedAt"]; ?></td>
            </tr>
            <?php 
            }
            ?>
        </table>
    </div>
    <?php
}
    else{
        echo  '<script type=text/javascript>alert(" شما اجازه ورد به این صفحه را ندارید  ")</script>' ;
        header("Refresh: 0;location:login.php");
    }?>
</body>
</html>