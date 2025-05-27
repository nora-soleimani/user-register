<?php 
require_once ("assets/controler/CityClass.php");

$City=new City();

if (isset($_GET["action"])) {
    if($_GET["action"]=="show"){

        $_SESSION["idProvince"]=$_GET["idProvince"];
        $City->Show_City($_SESSION["idProvince"]);
        $nameProvince=$City->Nameprovince($_SESSION["idProvince"]);
        if($_GET["action"]=="showform"){
            $action="edit";
        }
    }

    if ($_GET["action"] == "edit") {
        $action="edit";
        $City->Show_City($_SESSION["idProvince"]);
        $nameProvince=$City->Nameprovince($_SESSION["idProvince"]);
        $Cityedit=$City->EditCity($_GET["id"]);
          
    }    
    if($_GET["action"]=="create"){
        $action="create";
        $City->Show_City($_SESSION["idProvince"]);
        $nameProvince=$City->Nameprovince($_SESSION["idProvince"]);
    }
    if($_GET["action"]=="Delete"){
        $City->Show_City($_SESSION["idProvince"]);
        $nameProvince=$City->Nameprovince($_SESSION["idProvince"]);
        $City->Delete($_GET["id"]);

    }
    if ($_GET["action"] == "exit") {
        session_destroy();
        header("location:login.php");
    }
}
if(isset($_POST["update"])){
    $City->Show_City($_SESSION["idProvince"]);
    $nameProvince=$City->Nameprovince($_SESSION["idProvince"]);

    $City->UpdateCity($_POST["City"],$_GET["id"]);
    $action="false";      
}
if(isset($_POST["register"])){
    $City->Show_City($_SESSION["idProvince"]);
    $City->Create($_SESSION["idProvince"],$_POST["City"]);
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
    <title>شهرستان ها</title>

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
        <h2>لیست شهرستان های استان <?php echo $nameProvince["ProvinceName"]?></h2>
       <a href="?action=create">اضافه کردن شهرستان جدید</a>
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
               
                <th>نام شهرستان</th>
                <th>ویرایش</th>
                <th>حذف</th>
            </tr>
            <?php
            foreach($City->Citylist as $value){ 
                ?>
            <tr>
               
                <td><?php  echo $value["CityName"];?></td>
                <td><a href="citys.php?action=edit&id=<?php echo $value["IDCity"]?>">ویرایش</a></td>
                <td><a href="citys.php?action=Delete&id=<?php echo $value["IDCity"]?>">حذف</a></td>
            </tr>
            <?php 
            }
            ?>
        </table>
    </div>
    <?php 
    if (isset($_GET["action"])) {
        if ($_GET["action"] == "edit" || $_GET["action"] =="create") {

        ?>
           <div class="form-container">
                <h2>فرم </h2>
                <?php if (isset($_GET['message'])): ?>
                <div class="message <?php echo htmlspecialchars($_GET['type']); ?>">
                    <?php echo htmlspecialchars($_GET['message']); ?>
                </div>
                <?php endif; ?>
                <form action="" method="post" >
                    <div class="form-group">
                        <label for="City">نام شهرستان:</label>
                        <input type="text" id="City" name="City" value="<?php if(isset($Cityedit)){echo $Cityedit["CityName"];} ?>" required>
                    </div>
                 
                    
                    <button name="<?php
                    if (isset($Cityedit)){
                            echo "update";
                    }
                    else{
                        echo "register";
                    }
                    
                    ?>"><?php
                    if (isset($Cityedit)){
                        echo "ویرایش";
                    }
                    else{echo "افزودن";}
            ?></button>
                </form>     

            </div>
        <?php

        }
    }
    }
    ?>
</body>
</html>