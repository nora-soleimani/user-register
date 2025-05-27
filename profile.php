<?php 
require_once ("assets/controler/UserClass.php");
require_once ("assets/controler/ProvincesClass.php");
require_once ("assets/controler/ValidationClass.php");

 $Users=new User();
 $Provinces=new Provinces();
 $vaidation=new Validation();

 $Provinces->Show_Provinces();

 if(isset($_SESSION["ID_User"])){
    $id=$_SESSION["ID_User"];
    $userdata=$Users->showUser($id);

 }
 if (isset($_GET["action"])) {
    if ($_GET["action"] == "edit") {
        $action="edit";
        $useredit=$Users->Edit($id);
    } 

    if($_GET["action"]=="exit"){
        session_destroy();
        header("location:login.php");
    }
}
if(isset($_POST["update"])){
    $data=$Users->UpdateUser($id);
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
  
        if($_SESSION["LevelID"]>=5){
       
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
                <th>عکس</th>
                <th>نام</th>
                <th>نام خانوادگی</th>
                <th>کد ملی</th>
                <th>شماره همراه</th>
                <th>تاریخ تولد</th>
                <th>جنسیت</th>
                <th>ایمیل</th>
                <th>نام کاربری</th>
                <th>استان</th>
                <th>شهرستان</th>
                <th>ویرایش</th>
            </tr>
            <tr>
               
                <td><img src="assets/public/uploads/<?php if(isset($userdata)){ if(isset($userdata["photo"])){echo $userdata["photo"];} } ?>" alt="User 1" width="50"></td>
                <td><?php if(isset($userdata)){ echo $userdata["first_name"];} ?></td>
                <td><?php if(isset($userdata)){ echo $userdata["last_name"];} ?></td>
                <td><?php if(isset($userdata)){ echo $userdata["national_code"];} ?></td>
                <td><?php if(isset($userdata)){ echo $userdata["phone_number"];} ?></td>
                <td><?php if(isset($userdata)){ echo $userdata["birth_date"];} ?></td>
                <td><?php if(isset($userdata)){if($userdata["gender"]=="male"){ echo "مرد";}else{ echo "زن" ;}} ?></td>
                <td><?php if(isset($userdata)){ echo $userdata["email"];} ?></td>
                <td><?php if(isset($userdata)){ echo $userdata["username"];} ?></td>
                <td><?php if(isset($userdata)){if(isset($userdata["ProvinceName"])){echo $userdata["ProvinceName"];} } ?></td>
                <td><?php if(isset($userdata)){ if(isset($userdata["CityName"])){echo $userdata["CityName"];}} ?></td>
                <td><a href="profile.php?action=edit&id=<?php echo $_SESSION["ID_User"]?>">ویرایش</a></td>
            </tr>
            
        </table>
    </div>
    <?php 
    if (isset($_GET["action"])) {
        if ($_GET["action"] == "edit") {

        ?>
           <div class="form-container">
                <h2>فرم </h2>
                <?php if (isset($_GET['message'])): ?>
                <div class="message <?php echo htmlspecialchars($_GET['type']); ?>">
                    <?php echo htmlspecialchars($_GET['message']); ?>
                </div>
                <?php endif; ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="firstName">نام:</label>
                        <input type="text" id="firstName" name="firstName" value="<?php if(isset($useredit)){echo $useredit["first_name"];} ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">نام خانوادگی:</label>
                        <input type="text" id="lastName" name="lastName" value="<?php if(isset($useredit)){echo $useredit["last_name"];} ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phoneNumber">شماره همراه:</label>
                        <input type="text" id="phoneNumber" name="phoneNumber" value="<?php if(isset($useredit)){echo $useredit["phone_number"];} ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="birthDate">تاریخ تولد:</label>
                        <input type="text" id="birthDate" name="birthDate" value="<?php if(isset($useredit)){echo $useredit["birth_date"];} ?>">
                    </div>
                    <div class="form-group">
                        <label for="gender">جنسیت:</label>
                        <select id="gender" name="gender" required>
                            <option value="<?php echo $useredit["gender"];?>"><?php if($userdata["gender"]=="male"){ echo "مرد";}else{ echo "زن" ;} ?></option>
                            <option value="male">مرد</option>
                            <option value="female">زن</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="photo">عکس:</label>
                        <input type="file" id="photo" name="photo"  accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="username">نام کاربری:</label>
                        <input type="text" id="username" name="username" value="<?php if(isset($useredit)){echo $useredit["username"];} ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">رمز عبور:</label>
                        <input type="password" id="password" name="password" value="<?php if(isset($useredit)){echo $useredit["password"];} ?>" required>
                    </div>
                                
                    <div class="form-group">
                        <label for="province">استان:</label>
                        <select id="province" name="province" required>
                            
                            <option value="<?php if(isset($useredit["IDProvince"])){ echo $useredit["IDProvince"];}?>">
                                <?php  if(isset($useredit["ProvinceName"])){ echo $useredit["ProvinceName"];}?></option>
                            
                            <?php
                            foreach ($Provinces->provinceslist as $value){
                            ?>
                            <option value="<?php echo $value["IDProvince"];?>"><?php echo $value["ProvinceName"];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="city">شهرستان:</label>
                        <select id="city" name="city" required>
                        <option value="<?php if(isset($useredit["IDCity"])){ echo $useredit["IDCity"];}?>">
                        <?php  if(isset($useredit["CityName"])){ echo $useredit["CityName"];}?></option>

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

