<?php 
require_once ("assets/controler/UserClass.php");
require_once ("assets/controler/LevelClass.php");

$Users=new User();
$level=new Level();
$Users->showAdmin();
$level->showlevel();

if (isset($_GET["action"])) {
    if ($_GET["action"] == "edit") {
        $action="edit";
        $adminEditLevel=$level->EditLevelAdmin($_GET["id"]);
    } 

    if($_GET["action"]=="exit"){
        session_destroy();
        header("location:login.php");
    }
}
if(isset($_POST["update"])){
    $level->UpdateLevelAdmin($_POST["level"],$_GET["id"]);
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
        <h2>اطلاعات کاربر</h2>
        <a href="newadmin.php">اضافه کردن ادمین جدید</a>
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
                <th>ایمیل</th>
                <th>سطح دسترسی</th>
                <th>ویرایش</th>
            </tr>
            <?php
            foreach($Users->listmaneger as $value){ 
                ?>
            <tr>
               
                <td><?php  echo $value["first_name"]; ?></td>
                <td><?php  echo $value["last_name"]; ?></td>
                <td><?php  echo $value["email"]; ?></td>
                <td><?php  echo $value["NameLevel"]; ?></td>
                <td><a href="maneger.php?action=edit&id=<?php echo $value["id"] ?>">ویرایش</a></td>
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
                <h2> تغییر سطح دسترسی</h2>
                <?php if (isset($_GET['message'])): ?>
                <div class="message <?php echo htmlspecialchars($_GET['type']); ?>">
                    <?php echo htmlspecialchars($_GET['message']); ?>
                </div>
                <?php endif; ?>
                <form action="" method="post">
                   
                                
                    <div class="form-group">
                        <label for="level">سطح دسترسی:</label>
                        <select id="level" name="level" required>
                            
                            <option value="<?php if(isset($adminEditLevel)){ echo $adminEditLevel["IDLevel"];}?>">
                                <?php  if(isset($adminEditLevel)){ echo $adminEditLevel["NameLevel"];}?></option>
                            
                            <?php
                            foreach ($level->listlevel as $value){
                            ?>
                            <option value="<?php echo $value["IdLevel"];?>"><?php echo $value["NameLevel"];?></option>
                            <?php
                            }
                            ?>
                        </select>
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
    <script src="./assets/public/js/jquery.min.js"></script>
    <script src="./assets/public/js/pikaday.js"></script>
    <script src="./assets/public/js/persian-date.js"></script>
    <script src="./assets/public/js/persian-datepicker.js"></script>

    <script>
       $(document).ready(function() {
            $('#birthDate').persianDatepicker({
                format: 'YYYY/MM/DD',
                autoClose: true,
                initialValue: false,
                calendar: {
                    persian: {
                        locale: 'fa',
                        showHint: true,
                        leapYearMode: "algorithmic"
                    }
                },
                navigator: {
                    scroll: {
                        enabled: true
                    }
                },
                toolbox: {
                    calendarSwitch: {
                        enabled: true,
                        format: 'MMMM'
                    }
                }
            });

            $('#province').change(function() {
                var provinceId = $(this).val();
                if (provinceId) {
                    $.ajax({
                        type: 'POST',
                        url: 'getCitiesByProvince.php',
                        data: {province_id: provinceId},
                        success: function(response) {
                            $('#city').html(response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error in AJAX request:', status, error);
                            alert('خطا در بارگذاری شهرستان‌ها');
                        }
                    });
                } else {
                    $('#city').html('<option value="">انتخاب شهرستان</option>');
                }
            });
        });
    </script>
</body>

</html>

