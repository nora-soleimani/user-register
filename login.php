<?php 
require_once ("assets/controler/LoginClass.php");

$login=new login();
if(isset($_POST["login"])){
    $login->login(); 
}

if (isset($_GET["action"])) {
    if ($_GET["action"] == "exit") {
            session_destroy();
            header("location:login.php");
    }
}
?>
<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحه ورود</title>
    <link rel="stylesheet" href="./assets/public/css/style.css">
</head>

<body>
    <?php 
        if(isset($_GET['type'])){
            if($_GET['type']=='success'){
               ?>
                 <nav class="navbar">
                        <ul>
                            <li><a href="profile.php">اطلاعات داشبورد </a></li>
                            <li><a href="?action=exit">خروج از حساب کاربری  </a></li>
                        </ul>
                    </nav>
                    <h1 class="titr">خوش آمدید <?php echo $_SESSION["name"];?></h1>
                    <?php
            }
            else{ 
                ?>
                <!-- فرم ورود -->
                <div class="form-container">
                    <h2>فرم ورود</h2>
                    <?php if (isset($_GET['message'])): ?>
                    <div class="message <?php echo htmlspecialchars($_GET['type']); ?>">
                        <?php echo htmlspecialchars($_GET['message']); ?>
                    </div>
                    <?php endif; ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="username">نام کاربری:</label>
                            <input type="text" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">رمز عبور:</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        <button type="submit" name="login">ورود</button>
                        <a href="register.php" class="register">  ثبت نام کنید  </a>
                    </form>
                </div>
                 <?Php
            }

        }
        else if(isset($_SESSION["ID_User"])){
  
            if($_SESSION["LevelID"]>=5){
           
                 echo  '<script type=text/javascript>alert(" شما اجازه ورد به این صفحه را ندارید  ")</script>' ;
                
                header("Refresh: 0 ;http:register.php");
            } 
            elseif($_SESSION["LevelID"]<=3){
       
          ?>
      
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
        <h1 class="titr">خوش آمدید <?php echo $_SESSION["name"];?></h1>
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
        <h1 class="titr">خوش آمدید <?php echo $_SESSION["name"];?></h1>
        <?php
            }
            
        }
        else{
            ?>
            <!-- فرم ورود -->
            <div class="form-container">
                <h2>فرم ورود</h2>
                <?php if (isset($_GET['message'])): ?>
                <div class="message <?php echo htmlspecialchars($_GET['type']); ?>">
                    <?php echo htmlspecialchars($_GET['message']); ?>
                </div>
                <?php endif; ?>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="username">نام کاربری:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">رمز عبور:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" name="login">ورود</button>
                    <a href="register.php" class="register">  ثبت نام کنید  </a>
                </form>
            </div>
            <?php
        }
       
    ?>




</body>

</html>