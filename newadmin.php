<?php 
require_once ("assets/controler/ValidationClass.php");
require_once ("assets/controler/ProvincesClass.php");
require_once ("assets/controler/VerifyClass.php");

$Users=new User();
$Provinces=new Provinces();
$vaidation=new Validation();
$Verify=new Vrify();

$Provinces->Show_Provinces();

if(isset($_GET["type"])){
    if($_GET["type"]=="success"){
        sleep(3);
        $Verify->SendEmail();
    }

}
if(isset($_POST["register"])){
    $vaidation->check();
    $Users->CreateNewAdmin();
}


?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحه عضویت</title>
    <link rel="stylesheet" href="./assets/public/css/pikaday.css">
    <link rel="stylesheet" href="./assets/public/css/persian-datepicker.min.css">
    <link rel="stylesheet" href="./assets/public/css/style.css">
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
    <div class="form-container">
        <h2>فرم عضویت ادمین</h2>
        <?php if (isset($_GET['message'])): ?>
        <div class="message <?php echo htmlspecialchars($_GET['type']); ?>">
            <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
        <?php endif; ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="firstName">نام:</label>
                <input type="text" id="firstName" name="firstName" required>
            </div>
            <div class="form-group">
                <label for="lastName">نام خانوادگی:</label>
                <input type="text" id="lastName" name="lastName" required>
            </div>
            <div class="form-group">
                <label for="nationalCode">کد ملی:</label>
                <input type="text" id="nationalCode" name="nationalCode" required>
            </div>
            <div class="form-group">
                <label for="phoneNumber">شماره همراه:</label>
                <input type="text" id="phoneNumber" name="phoneNumber" required>
            </div>
            <div class="form-group">
                <label for="birthDate">تاریخ تولد:</label>
                <input type="text" id="birthDate" name="birthDate">
            </div>
            <div class="form-group">
                <label for="gender">جنسیت:</label>
                <select id="gender" name="gender" required>
                    <option value="male">مرد</option>
                    <option value="female">زن</option>
                </select>
            </div>
            <div class="form-group">
                <label for="email">ایمیل:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="photo">عکس:</label>
                <input type="file" id="photo" name="photo"  accept="image/*">
            </div>
            <div class="form-group">
                <label for="username">نام کاربری:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">رمز عبور:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">تکرار رمز عبور:</label>
                <input type="password" id="confirmPassword" name="confirmPassword">
            </div>
            <div class="form-group">
                <label for="province">استان:</label>
                <select id="province" name="province" >
                    <option value="">انتخاب استان</option>
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
                <select id="city" name="city">
                    <option value="">انتخاب شهرستان</option>
                </select>
            </div>
            <div class="form-group">
                <label for="captcha">کد امنیتی (CAPTCHA):</label>
                <img src="./assets/controler/captcha.php" alt="CAPTCHA Image" class="capcha"><br>
                <input type="text" id="captcha" name="captcha" required>
            </div>
            <button type="submit" name="register">ثبت نام</button>
            <a href="login.php" class="register">قبلا ثبت نام کردید</a>
        </form>
<?php
    }?>
    </div>
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