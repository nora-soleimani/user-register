<?php 
require_once ("assets/controler/ProvincesClass.php");

$Provinces=new Provinces();

$Provinces->Show_Provinces();
if (isset($_GET["action"])) {

    
    if ($_GET["action"] == "edit") {
        $action="edit";
        $provincesedit=$Provinces->Editprovinces($_GET["id"]);
          
    }    
    if ($_GET["action"] == "exit") {
        session_destroy();
        header("location:login.php");
    }
}
if(isset($_POST["update"])){
    $Provinces->Updateprovinces($_POST["provinces"],$_GET["id"]);
    $action="false";      
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
    <title>استان ها</title>

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
    <!-- جدول اطلاعات استان -->
    <div class="table-container">
        <h2>اطلاعات استان ها</h2>
       
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
               
                <th>نام استان</th>
                <th>مشاهده لیست شهر های این استان</th>
                <th>ویرایش</th>
            </tr>
            <?php
            foreach($Provinces->provinceslist as $value){ 
                ?>
            <tr>
               
                <td><?php  echo $value["ProvinceName"];?></td>
                <td><a href="citys.php?action=show&idProvince=<?php echo $value["IDProvince"]?>">مشاهده لیست</a></td>
                <td><a href="state.php?action=edit&id=<?php echo $value["IDProvince"]?>">ویرایش</a></td>
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
                <h2>فرم عضویت</h2>
                <?php if (isset($_GET['message'])): ?>
                <div class="message <?php echo htmlspecialchars($_GET['type']); ?>">
                    <?php echo htmlspecialchars($_GET['message']); ?>
                </div>
                <?php endif; ?>
                <form action="" method="post" >
                    <div class="form-group">
                        <label for="provinces">نام استان:</label>
                        <input type="text" id="provinces" name="provinces" value="<?php if(isset($provincesedit)){echo $provincesedit["ProvinceName"];} ?>" required>
                    </div>
                 
                    
                    <button type="submit"  name="update">ویرایش</button>
                </form>     

            </div>
        <?php

        }
    }
    }
    ?>
</body>
</html>